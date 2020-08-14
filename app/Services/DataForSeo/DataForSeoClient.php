<?php

namespace App\Services\DataForSeo;

use App\Services\DataForSeo\RestClient;
use App\Services\DataForSeo\RestClientException;
use Illuminate\Support\Facades\Log;
use App\Task;
use App\TaskResult;

/**
* Client for work with Data For Seo API
*/
class DataForSeoClient
{
    protected $client;
    protected $task;


    public function __construct(RestClient $client, Task $task)
    {
        $this->client = $client;
        $this->task = $task;
    }

    /**
    * Returns the serch engine by country code
    *
    * @param string $code
    * @return array
    */
    public function getSearchEngine($code = '')
    {
        try {
            $searchEngines = $this->client->get('v2/cmn_se/' . $code);

            return [
                'status' => 200,
                'data' => $this->arrayUniqueKey($searchEngines['results'], 'se_name')
            ];
        } catch (RestClientException $e) {
            return [
                'status' => $e->getHttpCode(),
                'data' => "Error code: {$e->getCode()}" . "Message: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Setting SERP tasks
     *
     * @param array $data
     * @return array
     */
    public function createTask($data)
    {
        $my_unq_id = mt_rand(0, 30000000);

        $post_array[$my_unq_id] = array(
            "priority" => 1,
            "se_id" => $data["searchEngin"],
            "se_language" => "English",
            "loc_name_canonical" => $data["location"],
            "key" => mb_convert_encoding($data["searchPhrase"], "UTF-8"),
            "pingback_url" => trim(config('dataforseo.base_url'), '/') .
                '/data-for-seo-pingback/?task_id=$task_id&token=' .
                config('dataforseo.se_token')
        );

        try {
            $taskPostResult = $this->client->post('/v2/srp_tasks_post', array('data' => $post_array));

            if ($taskPostResult['status'] =='error') {
                throw new RestClientException(
                    $taskPostResult['error'][$my_unq_id]['message'],
                    $taskPostResult['error'][$my_unq_id]['code'],
                    $taskPostResult['error'][$my_unq_id]['code']
                );
            }
            $this->task->task_id = $taskPostResult['results'][$my_unq_id]['task_id'];
            $this->task->saveOrFail();

            return [
                'status' => 200,
                'data' => 'Success!'
            ];
        } catch (RestClientException $e) {
            return [
                'status' => $e->getHttpCode(),
                'data' => "Error code: {$e->getCode()}" . " Message: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Save completed tasks to DB
     *
     * @param int $taskId
     * @return void
     */
    public function saveTaskResult($taskId)
    {
        $taskData = $this->getTaskResult($taskId);

        if ($taskData['status'] != 200) {
            $taskObj = $this->task->firstWhere('task_id', $taskId);

            if ($taskObj !== null) {
                $taskObj->update(['status' => $taskData['status']]);
            }

            return false;
        }

        if (count($taskData['data'])) {
            $taskObj = $this->task->firstWhere('task_id', $taskId);

            if ($taskObj === null) return false;

            $taskObj->results()->saveMany($taskData['data']);
            $taskObj->update(['status' => 1]);
        }
    }

    /**
     * Get SERP Completed Tasks
     *
     * @param int $taskId
     * @return array
     */
    protected function getTaskResult($taskId)
    {
        try {
            $serpResult = $this->prepareTaskResults($this->client->get('v2/srp_tasks_get/'.$taskId)['results']);

            return [
                'status' => 200,
                'data' => $serpResult
            ];
        } catch (RestClientException $e) {
            Log::error("DataForSeo get task result error!");
            Log::error("Error code: {$e->getCode()}" . "Message: {$e->getMessage()}");

            return [
                'status' => $e->getHttpCode(),
                'data' => "Error code: {$e->getCode()} Message: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Finding unique values ​​for search engines
     *
     * @param array $array search engine data
     * @param string $key search engine name
     * @return array
     */
    protected function arrayUniqueKey($array, $key)
    {
        $tmp = $key_array = array();
        $i = 0;

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $tmp[$i] = $val;
            }
            $i++;
        }

        return $tmp;
    }
    /**
     * Prepare task result before save to DB
     *
     * @param array $data
     * @return array
     */
    protected function prepareTaskResults($data)
    {
        $saveLines = [];

        if (!isset($data['organic'])) return $saveLines;

        foreach ($data['organic'] as $val) {
            $saveLines[] = new TaskResult([
                'post_key' => $val['post_key'],
                'result_url' => $val['result_url'],
                'result_title' => $val['result_title'],
                'loc_id' => $val['loc_id'],
            ]);
        }

        return $saveLines;
    }

    /**
     * Get all task from DB
     *
     * @return Task
     */
    public function getTaskList()
    {
        $taskList = $this->task->all();

        return $taskList;
    }

    /**
     * Return task results by task id
     *
     * @param int $id
     * @return Task
     */
    public function getTaskResults($id)
    {

        $taskObj = $this->task->firstWhere('task_id', $id);

        if ($taskObj === null) return [];

        return $taskObj->results()->paginate(5);
    }
}

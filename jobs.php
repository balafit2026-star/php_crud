<?php

require_once __DIR__ . '/Config/bootstrap.php';
require_once __DIR__ . '/Models/Job.php';

use App\Models\Job;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

try {

    switch ($method) {

        // =========================
        // GET - READ
        // =========================
        case 'GET':

            // Get one job
            if (isset($_GET['id'])) {

                $job = Job::find($_GET['id']);

                if (!$job) {
                    http_response_code(404);

                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Job not found'
                    ]);

                    exit;
                }

                echo json_encode([
                    'status' => 'success',
                    'data' => $job
                ]);

                exit;
            }

            // Get all jobs
            $jobs = Job::orderBy('Id', 'desc')->get();

            echo json_encode([
                'status' => 'success',
                'data' => $jobs
            ]);

            break;


        // =========================
        // POST - CREATE
        // =========================
        case 'POST':

            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input || empty($input['Title'])) {

                http_response_code(400);

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Title is required'
                ]);

                exit;
            }

            $job = Job::create([
                'Title' => $input['Title']
            ]);

            http_response_code(201);

            echo json_encode([
                'status' => 'success',
                'message' => 'Job created successfully',
                'data' => $job
            ]);

            break;


        // =========================
        // PUT - UPDATE
        // =========================
        case 'PUT':

            if (!isset($_GET['id'])) {

                http_response_code(400);

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Job ID is required'
                ]);

                exit;
            }

            $job = Job::find($_GET['id']);

            if (!$job) {

                http_response_code(404);

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Job not found'
                ]);

                exit;
            }

            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input || empty($input['Title'])) {

                http_response_code(400);

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Title is required'
                ]);

                exit;
            }

            $job->Title = $input['Title'];

            $job->save();

            echo json_encode([
                'status' => 'success',
                'message' => 'Job updated successfully',
                'data' => $job
            ]);

            break;


        // =========================
        // DELETE
        // =========================
        case 'DELETE':

            if (!isset($_GET['id'])) {

                http_response_code(400);

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Job ID is required'
                ]);

                exit;
            }

            $job = Job::find($_GET['id']);

            if (!$job) {

                http_response_code(404);

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Job not found'
                ]);

                exit;
            }

            $job->delete();

            echo json_encode([
                'status' => 'success',
                'message' => 'Job deleted successfully'
            ]);

            break;


        // =========================
        // INVALID METHOD
        // =========================
        default:

            http_response_code(405);

            echo json_encode([
                'status' => 'error',
                'message' => 'Method not allowed'
            ]);

            break;
    }

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
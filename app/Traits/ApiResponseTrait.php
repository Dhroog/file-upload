<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected $status = 200;

    public function SetStatus($status)
    {
        $this->status = $status;
    }

    public function Response($message,$data = null): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data
            ],
            $this->status
        );
    }

    public function SuccessResponse($message = null)
    {
        return response()->json(
            [
                'message' => $message ?? 'Success',
                'Success' => true
            ],
            200
        );
    }

    public function failureResponse($message = null): JsonResponse
    {
        $this->SetStatus(400);
            return $this->Response(
                $message ?? 'failure',
            );
    }

    public function CreatedResponse($data = null,$message = null)
    {
        return $this->Response(
            $message ?? 'Data created successfully',
            $data
        );
    }

    public function UpdatedResponse($data = null,$message = null)
    {
        return $this->Response(
            $message ?? 'Data Updated successfully',
            $data
        );
    }

    public function DeletedResponse($message = null)
    {
        $this->Response(
            $message ?? 'Data Deleted successfully',
        );
    }

}

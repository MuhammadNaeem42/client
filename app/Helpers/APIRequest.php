<?php


namespace App\Helpers;


use App\Traits\ResponseUtil;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;


class APIRequest extends FormRequest
{
    use ResponseUtil;
    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     *
     * @return Response
     */
    public function response(array $errors)
    {
        $messages = implode(' ', Arr::flatten($errors));

        return Response::json(ResponseUtil::makeError($messages), 400);
    }
}

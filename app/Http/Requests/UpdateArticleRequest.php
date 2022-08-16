<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Route $route)
    {
        $method = $route->getActionMethod();
            if ($method == "deleteContributor") {
                return [
                    "articleID" => "required|integer",
                    "contributors.*.contributorID" => "required|integer",
                    "contributors.*.isWaiting" => "required|boolean"
                ];
            } else if ($method == "update") {
                return [

                ];
            }
    }
}

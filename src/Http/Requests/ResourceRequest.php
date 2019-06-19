<?php

namespace APDevs\LaravelUtils\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ResourceRequest extends FormRequest
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return $this->callByRequestMethod('authorize');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->callByRequestMethod('rules');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function defaultRules()
	{
		return [];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function defaultAuthorize()
	{
		return true;
	}

	/**
	 * @param  string $type ['authorize', 'rules']
	 * @return mixed
	 */
	public function callByRequestMethod($type)
	{
		$actionMethod = Str::studly($this->route()->getActionMethod());
		$requestMethod = $type.strtoupper($actionMethod);

		if (method_exists($this, $requestMethod)) {
			return $this->$requestMethod();
		}

		$defaultMethod = 'default'.ucfirst($type);

		return $this->$defaultMethod();
	}

}

<?php

namespace App\Http\Requests;

use App\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $post = Post::find($this->segment(3));

        return $post!== null && $post->user_id ==Auth::user()->getKey();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $post_id = $this->segment(3);

        return [
            'title' => "sometimes|required|unique:posts,title,{$post_id},post_id|max:180",
            'slug' => "sometimes|unique:posts,slug,{$post_id},post_id|max:180|slug",
            'content' => 'sometimes|required'
        ];
    }

    public function messages()
    {
        return [
            'slug' => 'Slug format is not valid.',
        ];
    }

}

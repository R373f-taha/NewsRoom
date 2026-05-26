<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use App\Rules\SanitizeContent;
use App\Rules\SanitizeTitle;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       $user=$this->user();

       return $user->can('create', Article::class);
    }


    public function prepareForValidation()
    {
      $tags = $this->input('tags');

    if (is_string($tags)) {

        $tags = json_decode($tags, true);}

      $this->merge([
          'title'=>SanitizeTitle::clean($this->title),
         'content'=>SanitizeContent::clean($this->input('content')),
          'author_id'=>$this->user()->id,
          'tags'=>$tags
      ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
//var_dump($this->all());
        return [
            'title' => ['required', 'string','unique:articles,title','min:10', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'tags'=>['sometimes','array'],
            'tags.*'=>'exists:tags,id',
            'status' => ['required', 'in:draft,published,archived'],
            'author_id'=>'required|exists:users,id',
            'published_at'=>'required_if:status,published'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The article title is required.',
            'title.string' => 'The article title must be a string.',
            'title.unique' => 'An article with this title already exists.',
            'title.min' => 'The article title must be at least 10 characters.',
            'title.max' => 'The article title may not be greater than 255 characters.',
            'content.required' => 'The article content is required.',
            'content.string' => 'The article content must be a string.',
            'content.min' => 'The article content must be at least 100 characters.',
            'tags.array' => 'The tags must be an array of tag IDs.',
            'tags.*.exists' => 'One or more of the selected tags do not exist.',
            'status.required' => 'The article status is required.',
            'status.in' => 'The article status must be one of: draft, published, archived.',
        ];
    }



}

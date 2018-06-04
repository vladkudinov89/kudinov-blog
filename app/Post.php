<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{

    use Sluggable;

    protected $fillable = ['title', 'content'];

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;


    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;

    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadeImage($image)
    {
        if ($image == null) {
            return;
        }
        Storage::delete('uploads/' . $this->image);
        $filename = str_random(10) . '.' . $image->extension();
        $image->saveAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {
        if($this->image == null){
            return '/img/no-image.png';
        }
        return '/uploads' . $this->image;
    }

    public function setCategory($id)
    {
        if ($id) {
            return;
        }

        $this->category_id = $id;
        $this->save();
    }

    public function setTags($ids)
    {
        if ($ids == null) {
            return;
        }

        $this->tags()->sync($ids);
    }

    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

    public function setFeatured()
    {
        $this->is_feature = 1;
        $this->save();
    }

    public function setStandart()
    {
        $this->is_feature = 0;
        $this->save();
    }

    public function toggleStatus($value)
    {
        if ($value == null) {
            $this->setDraft();
        }

        return $this->setPublic();
    }

    public function toggleFeatured($value)
    {
        if ($value == null) {
            $this->setStandart();
        }

        return $this->setFeatured();
    }


}

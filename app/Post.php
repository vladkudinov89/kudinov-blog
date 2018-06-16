<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{

    use Sluggable;

    protected $fillable = ['title', 'content', 'date' , 'description'];

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        $this->removeImage();
        $this->delete();
    }

    public function removeImage()
    {
        if ($this->image != null) {
            Storage::delete('uploads/' . $this->image);
        }
    }

    public function uploadeImage($image)
    {
        if ($image == null) {
            return;
        }
        $this->removeImage();

        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {
        if ($this->image == null) {
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->image;
    }

    public function setCategory($id)
    {
        if (!$id) {
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
        $this->is_featured = 1;
        $this->save();
    }

    public function setStandart()
    {
        $this->is_featured = 0;
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

    public function getCategoryTitle()
    {
        return ($this->category != null)
            ?   $this->category->title
            :   'Нет категории';
    }

    public function getTagsTitles()
    {
        if (!$this->tags->isEmpty()) {
            return implode(" , ", $this->tags->pluck('title')->all());
        }
        return "Нет тегов";
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d' , $value)->format('d/m/y');
        return $date;
    }

    public function getCategoryID()
    {
        return $this->category != null ? $this->category->id : null;
    }

//    public function getTagID()
//    {
//        return $this->tags != null ? $this->tags : null;
//    }

    public function getDate()
    {
       return Carbon::createFromFormat('d/m/y' , $this->date)->format('F d, Y');
    }

    public function hasPrevious()
    {
        return self::where('id' , '<' , $this->id)->max('id');
    }

    public function getPrevious()
    {
        $postID = $this->hasPrevious();
        return self::find($postID);
    }

    public function getNext()
    {
        $postID = $this->hasNext();
        return self::find($postID);
    }

    public function hasNext()
    {
       return self::where('id' , '>' , $this->id)->min('id');
    }

    public function related()
    {
        return self::all()->except($this->id);
    }

    public function hasCategory()
    {
        return $this->category != null ? true : false;
    }


}

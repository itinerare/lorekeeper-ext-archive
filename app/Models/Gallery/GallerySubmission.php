<?php

namespace App\Models\Gallery;

use Config;
use DB;
use Carbon\Carbon;
use App\Models\Model;

class GallerySubmission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'collaborator_data', 
        'hash', 'extension', 'text', 'parsed_text',
        'description', 'parsed_description',
        'character_data', 'prompt_id', 'data', 
        'is_visible', 'status', 'vote_data'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_submissions';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
    /**
     * Get the user who made the submission.
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\User\User', 'user_id');
    }

    /**
     * Get the gallery this submission is in.
     */
    public function gallery() 
    {
        return $this->belongsTo('App\Models\Gallery\Gallery', 'gallery_id');
    }

    /**
     * Get the prompt this submission is for if relevant.
     */
    public function prompt() 
    {
        return $this->belongsTo('App\Models\Prompt\Prompt', 'prompt_id');
    }

    /**********************************************************************************************
    
        SCOPES

    **********************************************************************************************/

    /**
     * Scope a query to only include pending submissions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope a query to only include accepted submissions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'Accepted');
    }

    /**
     * Scope a query to only include viewable submissions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeViewable($query, $user)
    {
        if($user && $user->hasPower('manage_submissions')) return $query->where('status', 'Accepted');
        return $query->where('status', 'Accepted')->where('is_visible', 1);
    }

    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/gallery/'.floor($this->id / 1000);
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute()
    {
        return $this->id . '_'.$this->hash.'.'.$this->extension;
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        return public_path($this->imageDirectory);
    }
    
    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->has_image) return null;
        return asset($this->imageDirectory . '/' . $this->imageFileName);
    }

    /**
     * Get the data attribute as an associative array.
     *
     * @return array
     */
    public function getCollaboratorDataAttribute()
    {
        return json_decode($this->attributes['collaborator_data'], true);
    }
    
    /**
     * Get the data attribute as an associative array.
     *
     * @return array
     */
    public function getDataAttribute()
    {
        return json_decode($this->attributes['data'], true);
    }

    /**
     * Get the data attribute as an associative array.
     *
     * @return array
     */
    public function getCharacterDataAttribute()
    {
        return json_decode($this->attributes['character_data'], true);
    }

    /**
     * Get the data attribute as an associative array.
     *
     * @return array
     */
    public function getVoteDataAttribute()
    {
        return json_decode($this->attributes['vote_data'], true);
    }

    /**
     * Get the viewing URL of the submission/claim.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return '<a href="'.$this->url.'">'.$this->name.'</a>';
    }

    /**
     * Get the viewing URL of the submission/claim.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('gallery/'.$this->gallery->id.'/view/'.$this->id);
    }
    
}
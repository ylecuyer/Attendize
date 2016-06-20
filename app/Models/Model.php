<?php

namespace App\Models;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Model extends MyBaseModel implements StaplerableInterface
{
    use EloquentTrait;

    public function __construct(array $attributes = array()) {
      $this->hasAttachedFile('html');

      parent::__construct($attributes);
    }

    /**
      * The table associated with the model.
      *          
      * @var string
      */
    protected $table = 'invitations_models';

    /**
     * The validation rules of the model.
     *
     * @var array $rules
     */
    public $rules = [
        'name' => ['required'],
        'file'  => ['required'],
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'name.required' => 'Please enter a valid name',
        'file.required'  => 'Please enter a valid file',
    ];

    /**
     * The status associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo('\App\Models\Event');
    }
}

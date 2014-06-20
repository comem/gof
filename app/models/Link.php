<?php

class Link extends MyEloquent {

	protected $table = 'links';
	public $timestamps = false;

	public function artist()
	{
		return $this->belongsTo('Artist');
	}

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'url' => 'string|between:1,255|sometimes|required|unique:links',
            'name_de' => 'string|between:1,255|sometimes|required',
            'title_de' => 'string|between:1,255|sometimes',
            'artist_id' => 'unsigned|sometimes|required',
        ));
    }

    public static function existTechId($linkId) {
        $e = Link::find($linkId);
        return $e != null;
    }

    public static function existBusinessId($linkUrl) {
        $e = Link::where('url','=',$linkUrl)->first();
        return $e != null;
    }

}
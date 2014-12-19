<?php

/**
 * This is the model class for table "showcase".
 *
 * The followings are the available columns in table 'showcase':
 * @property integer $user_id
 * @property string $file_id
 * @property string $file_share_type
 * @property string $file_desc
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Showcase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'showcase';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, file_share_type', 'required'),
            array('user_id, file_id, preview_file_id', 'numerical', 'integerOnly'=>true),
            array('file_share_type', 'length', 'max'=>7),
            array('title', 'length', 'max'=>100),
            array('file_desc', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, file_id, file_share_type, file_desc, title, preview_file_id', 'safe', 'on'=>'search'),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'file' => array(self::BELONGS_TO, 'File', 'file_id'),
            'preview_image' => array(self::BELONGS_TO, 'File', 'preview_file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'file_id' => 'File',
            'file_share_type' => 'File Share Type',
            'file_desc' => 'File Desc',
            'title' => 'Title',
            'preview_file_id' => 'Preview File',
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('file_id',$this->file_id);
        $criteria->compare('file_share_type',$this->file_share_type,true);
        $criteria->compare('file_desc',$this->file_desc,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('preview_file_id',$this->preview_file_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Showcase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

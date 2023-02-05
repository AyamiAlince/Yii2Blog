<?php

namespace app\models;

use Yii;

use Yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'content'], 'string'],
            [['date'], 'safe'],
            [['viewed', 'user_id', 'status', 'category_id'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }


    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::class, ['article_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }
    
    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        return ($this->image) ? '../uploads/' . $this->image : '/no-image.png';
    }
    public function getImagePosts()
    {
        return ($this->image) ? '../uploads/' . $this->image : '/no-image.png';
    }
    public function getImagePosts2()
    {
        return ($this->image) ? 'web/uploads/' . $this->image : '/no-image.png';
    }
    public function getImageForAdmin()
    {
        return ($this->image) ? '../../uploads/' . $this->image : '/no-image.png';
    }
    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }
     public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
   public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    public function saveCategory($category_id) {
        
        $category = Category::findOne($category_id);
        if($category != null){
            $this->link('category', $category);
            return true;
        }
        
    }
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }
        public function getSelectedTags()
    {
         $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags)
    {
        if (is_array($tags))
        {
            $this->clearCurrentTags();

            foreach($tags as $tag_id)
            {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id'=>$this->id]);
    }
    public static function getAll($pageSize = 4)
    {
        // build a DB query to get all articles
        $query = Article::find()->orderBy('date desc');

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);

        // limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        
        return $data;
    }
    
    // public static function getPopular()
    // {
    //     return Article::find()->orderBy('viewed desc')->limit(1)->all();
    // }
    
    // public static function getRecent()
    // {
    //     return Article::find()->orderBy('date desc')->limit(1)->all();
    // }
    // public static function getRecentPosts()
    // {
    //     return Article::find()->orderBy('id desc')->all();
    // }



    public function getArticleComments()
    {
        return $this->getComments()->where(['status'=>1])->all();
    }
    
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
    
    public function viewedCounter()
    {
        $this->viewed += 1;
        return $this->save(false);
    }
}
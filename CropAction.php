<?php
namespace hyii2\avatar;
/**
 * @see Yii中文网  http://www.yii-china.com
 * @author Xianan Huang <Xianan_huang@163.com>
 * 头像上传组件
 * 如何配置请到官网（Yii中文网：www.yii-china.com）查看相关文章
 */
use Yii;
use yii\base\Action;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class CropAction extends Action
{
    public $config = [];
    
    public function init()
    {
        $config = [
            'bigImageWidth' => '200',   //大图默认宽度
            'bigImageHeight' => '200',  //大图默认高度
            'middleImageWidth'=> '100', //中图默认宽度
            'middleImageHeight'=> '100',//中图图默认高度
            'smallImageWidth' => '50',  //小图默认宽度
            'smallImageHeight' => '50', //小图默认高度
            //头像上传目录
            'uploadPath' => 'uploads/avatar',  
        ];
        $this->config = ArrayHelper::merge($config, $this->config);
        parent::init();
    }
    
    public function run()
    {
        $model = new UploadForm();
        
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $post = Yii::$app->request->post();
            $model->avatarData = $post['UploadForm']['avatarData'];
            $model->config = $this->config;
            if ($model->upload()) {
                // 文件上传成功
                return json_encode(['state'=>200,'message'=>'上传成功！','result'=>$model->imageUrl]);
            }
        }
    }
}
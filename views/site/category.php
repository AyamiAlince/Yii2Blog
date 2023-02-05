<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>


<main class="container">
    <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
      <div class="col-md-6 px-0">
        <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>
        <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
        <p class="lead mb-0"><a href="#" class="text-white fw-bold">Continue reading...</a></p>
      </div>
    </div>
    <?php foreach($popular as $article):?>
    <div class="row mb-2">
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">Популярный Пост</strong>
            <h3 class="mb-0"><?= $article->title;?></h3>
            <div class="mb-1 text-muted"><?= $article->date;?></div>
            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>" class="stretched-link">Continue reading</a>
          </div>
          <div class="col-2 w-25  d-none d-lg-block">
           <img src="<?= $article->getImage();?>"  height="250" alt="" srcset="">
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php foreach($recent as $article):?>
  
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success">Недавний Пост</strong>
            <h3 class="mb-0"><?= $article->title;?></h3>
            <div class="mb-1 text-muted"><?= $article->date;?></div>
            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>" class="stretched-link">Continue reading</a>
          </div>
          <div class="col-2 w-25  d-none d-lg-block">
           <img src="<?= $article->getImage();?>"  height="250" alt="" srcset="">
          </div>
        </div>
   
      <?php endforeach; ?>
      </div>
    </div>
  
    <div class="row g-5">
      <div class="col-md-8">
        <h3 class="pb-4 mb-4 fst-italic border-bottom">
          Посты
        </h3>
  

  
        <div class="container">

          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-1 g-3">

          <?php foreach($articles as $article):?>
            <div class="col">
              <div class="card shadow-sm">
                
                <img class="" src="<?= $article->getImage();?>"  alt="" >
                
              
                <small class="text-muted m-2 text-center"><?= $article->category->title;?></small>
                <div class="card-body">
                <samp>sd</samp>
                  <p class="card-text"><?= $article->description;?></p>
                  <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted"><?= $article->date;?></small>
                    <div class="btn-group">
                      <a type="button" href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>" class="btn btn-sm btn-outline-secondary">Подробнее</a>

                    </div>
                    
                    <small class="text-muted"><?= (int) $article->viewed;?> Просмотров</small>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
        </div>
  
        <hr>

        <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                ?>
  
      </div>
  
      <div class="col-md-4">
        <div class="position-sticky" style="top: 2rem;">
          <div class="p-4 mb-3 bg-light rounded">
            <h4 class="fst-italic">About</h4>
            <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
          </div>
  

  
          <div class="p-4">
            <h4 class="fst-italic">Категории</h4>
            
            <ol class="list-unstyled">
            <?php foreach($categories as $category):?>
              <li><a href="<?= Url::toRoute(['site/category', 'id'=>$category->id]);?>"><?= $category->title;?></a>
              <span> (<?= $category->getArticles()->count();?> )</span>
              </li>
              <?php endforeach;?>
            </ol>
          </div>
        </div>
      </div>
    </div>
  
  </main>
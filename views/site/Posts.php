<?php
use yii\helpers\Url;
?>



<main class="container">

<div class="row g-5">
  <div class="col-md-8">
    <h3 class="pb-4 mb-4 fst-italic border-bottom">

    </h3>



    <article class="blog-post">
    <div class="col-2 w-100 h-lg-25 d-none d-lg-block">
           <img src="<?= $article->getImage();?>"  height="450" alt="" srcset="">
          </div>
      <h2 class="blog-post-title mb-1"><?= $article->title?></h2>
      <p class="blog-post-meta"><?= $article->date;?> by <a href="#">Chris</a></p>

      <?= $article->content?>
    </article>

    <hr>
    <?= $this->render('/partials/comment', [
                 'article'=>$article,
                 'comments'=>$comments,
                 'commentForm'=>$commentForm
             ])?>


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
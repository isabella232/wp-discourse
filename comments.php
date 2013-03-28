<?php 
  $custom = get_post_custom();
  $options = get_option('discourse');
  $permalink = (string)$custom['discourse_permalink'][0];
  $discourse_url_name = preg_replace("(https?://)", "", $options['url'] );
  $discourse_info = json_decode($custom['discourse_comments_raw'][0]);

  $more_replies = $discourse_info->posts_count - count($discourse_info->posts);

  if($more_replies == 0) {
    $more_replies = "";
  } elseif($more_replies == 1) {
    $more_replies = "1 more reply";
  } else {
    $more_replies = $more_replies . " more replies";
  }

  function homepage($url, $post) {
    echo $url . "/users/" . strtolower($post->username);
  }

  function avatar($template, $size) {
    echo str_replace("{size}", $size, $template);
  }
?>

<?php # var_dump($discourse_info->posts) ?>

<div id="comments">
<h2 id="comments-title"> Notable replies to “<span><?php echo $post->post_title ?></span>”</h2>
		
		<ol class="commentlist">
      <?php foreach($discourse_info->posts as &$post) { ?>
        <li class="comment">
          <article class="comment">
            <footer class="comment-meta">
              
				<div class="comment-author vcard">
        <img alt="" src="<?php avatar($post->avatar_template,68) ?>" class="avatar avatar-68 photo avatar-default" height="68" width="68">
          <span class="fn"><a href="<?php homepage($options['url'],$post) ?>" rel="external" class="url"><?php echo $post->name ?></a></span>
          on <time pubdate="" datetime="<?php echo $post->created_at ?>"><?php echo mysql2date(get_option('date_format'), $post->created_at)?></time>
            <span class="says">said:</span></div>
            </footer>
            <div class="comment-content"><?php echo $post->cooked ?></div>
          </article>
        </li>
      <?php } ?>

		</ol>

		
	
    <div id="respond">
        <h3 id="reply-title">Discussion</h3>
        <p></p>
        <h2><a href="<?php echo $permalink ?>">Continue the discussion</a> at <a href="<?php echo $permalink ?>"><?php echo $discourse_url_name ?></a> <?php echo $more_replies ?></h2>
        <p>
          <?php foreach($discourse_info->participants as &$participant) { ?>
            <img alt="" src="<?php avatar($participant->avatar_template,25) ?>" class="avatar avatar-25 photo avatar-default" height="25" width="25">
          <?php } ?>
        </p>
    </div><!-- #respond -->
						
</div>

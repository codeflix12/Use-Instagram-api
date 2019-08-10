<!DOCTYPE html>
<html>
<head>
  <title>Instagram API</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>


<style>
  .posts{
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
  }

  .like-comment{
    font-size: 10px;
    color:#333;
    padding-bottom: 40px;
    font-weight: bold;
  }
</style>

<div class="container" style="margin-top:20px;margin-bottom:20px;padding:50px;background-color:#ddd;">
  <div class="row">
    <div class="col-md-3">
      <img src="" class="profile-pic" style="border-radius:50%;">
    </div>
    <div class="col-md-9">
      <h2 class="username"></h2>
      <div class="row">
        <div class="col-md-4">
          <span class="number-of-posts"></span> posts
        </div>
        <div class="col-md-4">
          <span class="followers"></span> followers
        </div>
        <div class="col-md-4">
          <span class="following"></span> following
        </div>
      </div>
      <div class="row" style="margin-top:60px;">
        <h4 class="name"></h4>
      </div>
      <div class="row">
        <h4 class="biography"></h4>
      </div>
      <br><hr><br>
      <div class="row">
        <p>POSTS</p>
      </div>
      <div class="row posts"></div>
    </div>
  </div>
</div>

<script>
  function nFormatter(num){
    
    if(num >= 1000000){
      return (num/1000000).toFixed(1).replace(/\.0$/,'') + 'M';
    }
    if(num >= 1000){
      return (num/1000).toFixed(1).replace(/\.0$/,'') + 'K';
    }
    return num;
  }


  $.ajax({
    url:"https://www.instagram.com/<?php echo $_GET['user'];?>?__a=1",
    type:'get',
    success:function(response){
      $(".profile-pic").attr('src',response.graphql.user.profile_pic_url);
      $(".name").html(response.graphql.user.full_name);
      $(".biography").html(response.graphql.user.biography);
      $(".username").html(response.graphql.user.username);
      $(".number-of-posts").html(response.graphql.user.edge_owner_to_timeline_media.count);
      $(".followers").html(nFormatter(response.graphql.user.edge_followed_by.count));
      $(".following").html(nFormatter(response.graphql.user.edge_follow.count));
      posts = response.graphql.user.edge_owner_to_timeline_media.edges;
      posts_html = '';
      for(var i=0;i<posts.length;i++){
        url = posts[i].node.display_url;
        likes = posts[i].node.edge_liked_by.count;
        comments = posts[i].node.edge_media_to_comment.count;
        posts_html += '<div class="col-md-4 equal-height"><img style="min-height:50px;background-color:#fff;width:100%" src="'+url+'"><div class="row like-comment"><div class="col-md-6">'+nFormatter(likes)+' LIKES</div><div class="col-md-6">'+nFormatter(comments)+' COMMENTS</div></div></div>';
      }
      $(".posts").html(posts_html);
    }
  });
</script>
</body>
</html>
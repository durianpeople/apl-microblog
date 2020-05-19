{% extends "../templates/base.volt" %}

{% block content %}
<div class="container">
    
    <div class="col s12 m8 offset-m2 l6 offset-l3">
        <div class="card-panel grey lighten-5 z-depth-1">
          <div class="row valign-wrapper">
            <div class="col s2">
              <img src="{{ url('images/tes.jpg') }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
            </div>
            <div class="col s10">
                <h5 class="title">{{post.username}}</h5>
                <p>{{post.content}}</p>
                <a href="/post/like/{{post.id}}"><i class="far fa-heart"></i> {{post.likes_count}}</a><br>
                <a href="/post/unlike/{{post.id}}"><i class="far fa-heart"></i>}</a>
            </div>
          </div>
        </div>
      </div>
    
</div>
{% endblock %}

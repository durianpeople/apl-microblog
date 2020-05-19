{% extends "../templates/base.volt" %}
{% block content %}
  <div class="container">
    <div class="row">
      <div class="col s12 m10 offset-m1">
        <div class="card" >
          <div class="card-content black-text row">
            <div class="right">
              <a href="/follow/{{complete_user_info.id}}" class="btn blue">Follow</a>
              <a href="/unfollow/{{complete_user_info.id}}" class="btn blue">Unfollow</a>
            </div>
            <div class="col s12 m6">
              <span class="card-title">_defunction
                <br><small><a href="#">@{{complete_user_info.username}}</a></small>
              </span>
              <div>
              <p>⏳on hiatus 🙂beautiful mind 🍝fried noodles |
                my twitter doesn't define me at all</p>
              </div>
              <br>
                <div>
                  East Java, Indonesialetterboxd.com/ranggakd/Born 1999Joined February 2012
                </div>
                <div>
                  {{complete_user_info.following_count}} Following {{complete_user_info.follower_count}} Followers
                </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
{% endblock %}
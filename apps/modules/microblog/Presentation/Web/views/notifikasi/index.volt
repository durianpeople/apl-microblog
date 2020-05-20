{% extends "../templates/base.volt" %}

{% block content %}
  <div class="container" style="margin-top: 3%;">
    <div class="row">
      <div class="col s12">
        <div class="right">
          <a class='dropdown-trigger btn' href='/read/all' data-target='dropdown1'>Mark all as read</a>
        </div>
      </div>
      
      <!-- <div class="col s12 m3">
        <div class="right">
          <a href="#"><i class="material-icons">check_circle</i>Clear All Notifications</a>
        </div>
      </div> -->
    </div>
    <ul class="collection">
        {%for notif in notifications%}
        <li class="collection-item avatar">
          <i class="material-icons circle {{notif.is_read ? 'gray' : 'blue'}}">notifications_none</i>
          <span class="title"><a href="#">@{{notif.username}}</a>
          <p class="truncate">{{notif.content}}</p>
          <small> {{notif.created_at}} </small>
          <div class="secondary-content row">
            <div class="col s12">
              <!-- <a href="#"><i class="material-icons">check</i></a> -->
              {%if notif.type_about is 'post'%}
              <a href="/read?guid={{notif.guid}}&type={{notif.type_about}}&id={{notif.id_about}}"><i class="material-icons">search</i></a>
              {%elseif notif.type_about is 'user'%}
              <a href="/read?guid={{notif.guid}}&type={{notif.type_about}}&id={{notif.id_about}}"><i class="material-icons">search</i></a>
              {%endif%}
              <a href="/notif_delete/{{notif.guid}}"><i class="material-icons">delete</i></a>
            </div>
          </div>  
        </li>
        {%endfor%}
        
      </ul>
  </div>


{% endblock %}
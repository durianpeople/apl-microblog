{% extends "../templates/base.volt" %}

{% block content %}
  <div class="container" style="margin-top: 3%;">
    <div class="row">
      <div class="col s12">
        <div class="right">
          <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>Mark all as read</a>
          <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>Clear Notifications</a>
        </div>
      </div>
      
      <!-- <div class="col s12 m3">
        <div class="right">
          <a href="#"><i class="material-icons">check_circle</i>Clear All Notifications</a>
        </div>
      </div> -->
    </div>
    <ul class="collection">
        <li class="collection-item avatar">
          <i class="material-icons circle gray">notifications_none</i>
          <span class="title">Yovi Agustian</span> - <a href="#">@yoviag</a>
          <p class="truncate">Loves you</p>
          <small> 20 Maret 2020 </small>
          <div class="secondary-content row">
            <div class="col s12">
              <!-- <a href="#"><i class="material-icons">check</i></a> -->
              <a href="#"><i class="material-icons">search</i></a>
              <a href="#"><i class="material-icons">delete</i></a>
            </div>
          </div>  
        </li>
        <li class="collection-item avatar">
          <i class="material-icons circle red">notifications_active</i>
          <span class="title">Yovi Agustian</span> | <a href="#">@yoviag</a>
          <p class="truncate">Mentions you</p>
          <small> 20 Maret 2020 </small>
          <div class="secondary-content row">
            <div class="col s12">
              <a href="#"><i class="material-icons">check</i></a>
              <a href="#"><i class="material-icons">search</i></a>
              <a href="#"><i class="material-icons">delete</i></a>
            </div>
          </div>  
        </li>
        
      </ul>
  </div>


{% endblock %}
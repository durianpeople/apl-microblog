{% extends "../templates/base.volt" %}
{% block content %}
  <div class="container">
    <div class="row">
      <div class="col s12 m6 offset-m3">
        <div class="card">
          <div class="card-content black-text center-align row">
            <div class="col s12">
              <span class="card-title">Profile</span>  
            </div>
            <form action="/profile" method="post">
            <input placeholder="user_id" id="user_id" type="hidden" class="validate" name="user_id" value='{{user_info.id}}'>
              <div class="input-field col s12">
                <input placeholder="Username" id="username" type="text" class="validate" name="username" value='{{user_info.username}}'>
                <label for="username">Username</label>
              </div>
              <div class="input-field col s12">
                <input placeholder="Old Pasword..." id="oldpassword" type="password" class ="validate" name="old_password">
                <label for="old_password">Old Password</label>
              </div>
              <div class="input-field col s12">
                <input placeholder="Pasword..." id="newpassword" type="password" class ="validate" name="new_password">
                <label for="new_password">New Password</label>
              </div>
              <div class="input-field col s12">
                <input placeholder="Re-type Pasword..." id="newpassword2" type="password" class ="validate" name="new_password2">
                <label for="new_password2">Retype Password</label>
              </div>
              <div class="col s12" >
                <!-- <a href="#" class="btn blue" type="submit" style="width:100%">Register</a> -->
                <button class="btn waves-effect waves-light blue" type="submit" name="action" style="width: 100%">Edit Profile
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </form>
          </div>
          <!-- <div class="card-action">
            <a href="#">This is a link</a>
          </div> -->
        </div>
      </div>
    </div>  
  </div>
{% endblock %}
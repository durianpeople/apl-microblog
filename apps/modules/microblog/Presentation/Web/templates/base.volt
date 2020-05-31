<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ url('css/materialize.min.css') }}"  media="screen,projection"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
      html{
        color: black;
      }
    </style>
  </head>
  <body>
    <nav class="blue">
      <div class="nav-wrapper container">
        <a href="/" class="brand-logo"><i class="fab fa-twitter fa-lg"></i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
        
        {% if session.get('user_info') == null %}
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Register</a></li>
        {% else %}
          <li><a href="/"><i class="fas fa-home fa-lg"></i></a></li>
          <li><a href="/hashtags"><i class="fas fa-hashtag fa-lg"></i></a></li>
          <li><a href="/notifikasi"><i class="fas fa-bell fa-lg"></i></a></li>
          <li><a href="/profile"><i class="fas fa-user fa-lg"></i></a></li>
          <li><a href="/search"><i class="fas fa-search fa-lg"></i></a></li>
          <li><a href="/logout">Logout</a></li>
        {% endif %}
        
        
      </ul>
      </div>
    </nav>
    {% block content %} {% endblock %}
    <!-- <div class="container">
      
    </div> -->

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{ url('js/materialize.min.js') }}"></script>
  </body>
</html>
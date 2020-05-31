{% extends "../templates/base.volt" %}

{% block content %}
<div class="container">
        
    <div class="collection">
    <!-- Tweet Box -->
        <div class="collection-item">
            <form class="col s12" action="/search" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <div class="col s1"><img src="images/tes.jpg" alt="" class="circle responsive-img"></div>
                    <div class="col s8">
                        <label for="icon_prefix2">Find your friends</label>
                        <textarea id="icon_prefix2" class="materialize-textarea" name="content"></textarea>
        
                        <button class="btn waves-effect waves-light, blue" type="submit" name="action">Search
                            <i class="material-icons right">search</i>
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>

    <!-- Post List -->
        {%for p in posts%}
        <a href="/post/{{p.id}}" class="collection-item">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="row valign-wrapper">
                        <div class="col s1">
                            <img src="images/tes.jpg" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s12">
                            <span class="black-text">{{p.username}}</span>
                        </div>
                </div>
            </div>
        </a>
        {%endfor%}
        
    </div>
</div>
{% endblock %}
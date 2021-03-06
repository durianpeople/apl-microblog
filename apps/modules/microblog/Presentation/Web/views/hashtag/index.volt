{% extends "../templates/base.volt" %}

{% block content %}
<div class="container">
        
    <div class="collection">
    <!-- Post List -->
        {%for post in posts%}
        <a href="/post/{{post.id}}" class="collection-item">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="row valign-wrapper">
                        <div class="col s1">
                            <img src="{{ url('images/tes.jpg') }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s12">
                            <span class="black-text">{{post.username}}</span>
                            <br>
                            <span class="black-text">{{post.content}}</span>
                        </div>
                </div>
            </div>
        </a>
        {%endfor%}
        
    </div>
    
</div>
{% endblock %}

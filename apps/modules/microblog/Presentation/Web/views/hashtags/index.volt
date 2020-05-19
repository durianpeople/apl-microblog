{% extends "../templates/base.volt" %}

{% block content %}
<div class="container">
        
    <div class="collection">
    <!-- Post List -->
        {%for hashtag in hashtags%}
        <a href="/h/{{hashtag.hashtag}}" class="collection-item">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="row valign-wrapper">
                        <div class="col s12">
                            <h4 class="grey-text">#{{hashtag.hashtag}}</h4>
                        </div>
                </div>
            </div>
        </a>
        {%endfor%}
        
    </div>
    
</div>
{% endblock %}

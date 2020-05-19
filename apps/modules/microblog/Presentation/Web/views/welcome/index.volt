{% extends "../templates/base.volt" %}

{% block content %}
<div class="container">
        
    <div class="collection">
    <!-- Tweet Box -->
        <div class="collection-item">
            <form class="col s12" action="/" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <div class="col s1"><img src="images/tes.jpg" alt="" class="circle responsive-img"></div>
                    <div class="col s8">
                        <label for="icon_prefix2">Tweet</label>
                        <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
        
                        <button class="btn waves-effect waves-light, blue" type="submit" name="action">Tweet
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>

    <!-- Post List -->
        <a href="#!" class="collection-item">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="row valign-wrapper">
                        <div class="col s1">
                            <img src="images/tes.jpg" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s12">
                            <span class="black-text">Bagas</span>
                            <br>
                            <span class="black-text"> This is a square image. Add the "circle" class to it to make it appear circular.</span>
                        </div>
                </div>
            </div>
        </a>

        <a href="#!" class="collection-item">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="row valign-wrapper">
                        <div class="col s1">
                            <img src="images/tes.jpg" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s12">
                            <span class="black-text">Bagas</span>
                            <br>
                            <span class="black-text"> This is a square image. Add the "circle" class to it to make it appear circular.</span>
                        </div>
                </div>
            </div>
        </a>

        <a href="#!" class="collection-item">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="row valign-wrapper">
                        <div class="col s1">
                            <img src="images/tes.jpg" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s12">
                            <span class="black-text">Bagas</span>
                            <br>
                            <span class="black-text"> This is a square image. Add the "circle" class to it to make it appear circular.</span>
                        </div>
                </div>
            </div>
        </a>
        
    </div>
</div>
{% endblock %}
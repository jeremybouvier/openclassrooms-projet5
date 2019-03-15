
{% extends '/templates/default.php' %}

{% block content %}
    {% for posts in Post%}
        <div class="col-4">
            <div class="card" style="background-color: darkgray;">
                <div class="card-content">
                    <h2>{{posts.title}}</h2>
                    <p>{{posts.previewText}}</p>
                </div>
                <div class="card-footer">
                    <p style="text-right"><a href="../post/{{posts.id}}" >Voir article</a></p>
                </div>


            </div>
        </div>
    {% endfor %}

{% endblock %}
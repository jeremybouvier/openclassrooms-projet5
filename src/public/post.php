{% extends 'templates/default.php'%}
    {% block content%}

        <div class="col-12" >
            <div class="card " style="background-color:darkgray " >
                <div class="card-content p-2">
                    <h1>{{Post.title}}</h1>
                    <p>{{Post.content}}</p>
                </div>
                <div class="card-footer">
                    <p class=" text-right"><a  href="../listpost" >Retour a la list des posts</a></p>
                </div>
            </div>


        </div>
    {% include 'comment.php'%}
    {% endblock content %}



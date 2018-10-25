$(document).ready(function () {
    $(".main").addClass('loaded');
    $(window).on('beforeunload', function () {
        $('.main').removeClass('loaded');
    });

    var speed, scroll, container = $('.imgContent'), container_w, max_scroll;
    

    $("form").on('change', function(e){
        e.preventDefault();
        var file = $('input[type="file"]').val().trim();
        if (file) {
            $(".imgContent").css({'display':'flex'});
            $.ajax({
                url: "src/model/uploadFilesModel.php",
                type: "POST",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    errors = data['error'];
                    console.log(errors);
                    data = data['success'];
                    for (let i = 0; i < data.length; i++) {
                        $('.imgContent').prepend(
                            '<img itemid="itm-'+i+'" class="theImages" src="data/images/' + data[i]+'" alt="no image">'
                        );
                    }
                    $('.theImages').draggable({
                        // revert: 'invalid',
                        snap: true,
                        appendTo: 'body',
                        // containment: '.creation',
                        scroll: false,
                        cursor: "move",
                        helper: "clone",
                    });
                    if (errors.length > 0) {
                        for (let i = 0; i < errors.length; i++) {
                            $('.errors').append("<li>" + errors[i] + " n'est pas du bon format</li><br>");
                        }
                    }
                    else{
                        $('.errors').empty();
                    }
                },
                error: function(error){
                    console.log('error',error);
                }
            })
            speed = 0;
            scroll = 0;
            container_w = container.width();
            max_scroll = container[0].scrollWidth - container_w;
        }
        
    })
    $('.creation').droppable({
        accept: '.theImages',
        drop: function (event) {
            var itemid = $(event.originalEvent.toElement).attr("itemid");
            $('.theImages').each(function () {
                if ($(this).attr("itemid") === itemid) {
                    $(this).appendTo(".creation");
                }
            });
            console.log('Action terminée !', event);
        }
    });
    $('.imgContent').droppable({
        // accept: '.theImages',
        drop: function (event) {
            var itemid = $(event.originalEvent.toElement).attr("itemid");
            $('.theImages').each(function () {
                if ($(this).attr("itemid") === itemid) {
                    $(this).appendTo(".imgContent");
                }
            });
            console.log('Action terminée !', event);
        }
    });


    var isDragging = false;
    $('body').on('mousedown', ".theImages", function(){
            console.log('not dragging');
            // $(this).addClass('.draggableSize');
            $(this).css({'width':'100px'});
    })
    // $('body').on('mousemove', '.theImages', function(){
    //     // $(this).removeClass('.draggableSize');
    //     $(this).addClass('.draggableSize');
    //     console.log('dragging');

    // })
    $('body').on('mouseup', ".theImages", function () {
        console.log('was dragging');
        $('.theImages').css({ 'width': '100px' });

    });


    // GENERE LA VUE
    $('body').on('click', '.clickView', function(){
        let val = [];
        $('.creation img').each(function(){
            val.push($(this).attr('src'));
                }
        );
        $.ajax({
            url: "src/model/uploadFilesModel.php",
            type: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log(data);
                errors = data['error'];
                console.log(errors);
                data = data['success'];
                for (let i = 0; i < data.length; i++) {
                    $('.imgContent').prepend(
                        '<img itemid="itm-' + i + '" class="theImages" src="data/images/' + data[i] + '" alt="no image">'
                    );
                }
                $('.theImages').draggable({
                    // revert: 'invalid',
                    snap: true,
                    appendTo: 'body',
                    // containment: '.creation',
                    scroll: false,
                    cursor: "move",
                    helper: "clone",
                });
                if (errors.length > 0) {
                    for (let i = 0; i < errors.length; i++) {
                        $('.errors').append("<li>" + errors[i] + " n'est pas du bon format</li><br>");
                    }
                }
                else {
                    $('.errors').empty();
                }
            },
            error: function (error) {
                console.log('error', error);
            }
        })
    })





    $('section').on('mouseover','.theImages', function(){
        $(this).removeClass('imgOut').addClass('imgHover');
    }).on('mouseout', '.theImages',function(){
        $(this).removeClass('imgHover').addClass('imgOut');
    })
    $('section').on('click', '.theImages', function(){
        $('.modifyImage').css({ 'display': 'block' });
        $('#imgDisplay').html(
            '<img class="theImages" src="' + $(this).attr('src') + '" alt="no image">'
        );;

    })
    $('#closeModifyImage').on('click', function(){
        $('.modifyImage').css({'display':'none'});
    })
    $(window).resize(function(){
        container_w = container.width();
        max_scroll = container[0].scrollWidth - container_w;
    })
    container.on('mousemove', function (e) {
        var mouse_x = e.pageX - container.offset().left;
        var mouseperc = 100 * mouse_x / container_w;
        speed = mouseperc - 50;
    }).on('mouseleave', function () {
        speed = 0;
    });
    function updatescroll() {
        max_scroll = container[0].scrollWidth - container_w
        if (speed !== 0) {
            scroll += speed / 2;
            if (scroll < 0) scroll = 0;
            if (scroll > max_scroll) scroll = max_scroll;
            $('.imgContent').scrollLeft(scroll);
        }
        window.requestAnimationFrame(updatescroll);
    }
    window.requestAnimationFrame(updatescroll);


});
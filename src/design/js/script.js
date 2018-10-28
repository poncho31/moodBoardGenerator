let incrementImage = 0;
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
                            '<img itemid="itm-'+incrementImage+'" class="theImages" src="data/images/' + data[i]+'" alt="no image">'
                        );
                        incrementImage++;
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
    $('.imgContent').on('mousedown', ".theImages", function(){
            console.log('not dragging');
            $(this).css({'width':'150px'});
    }).on('mousemove', '.theImages', () => { console.log('moving');})

    // $('body').on('mousemove', '.theImages', function(){
    //     // $(this).removeClass('.draggableSize');
    //     $(this).addClass('.draggableSize');
    //     console.log('dragging');
    // })

    $('.creation').on('mouseup', ".theImages", function () {
        console.log('was dragging');
        $(this).css({ 'width': '150px' });

    });

    // $('.theImages').on('mousedown', function () {
    //     console.log('was dragging');
    //     $(this).css({ 'width': '1000px' });

    // });

    // GENERE LA VUE -mixe les images
    $('body').on('click', '.clickView', function(){
        // IMG
        let imgValues = [];

        // Images Effects
        let pixeliseBool = 0; // true
        let pixelIncrementX = rand(50, 50);
        let pixelIncrementY = rand(50, 50);
        let pixelDivider = 2;
        let pixelOperator = 0; // true
        let pixelOrientationX = 0; // entre 0 et 15
        let pixelOrientationY= 0; // entre 0 et 15

        let quadrillageBool = 0;
        let quadrillageH = 1; // true
        let quadrillageV = 1; // true
        let quadriPixelIncrementX = 50;
        let quadriPixelIncrementY = 50;
        let quadriThickH = 0;
        let quadriThickV = 0;
        let quadriColorRandomBool = 1; // false
        let quadriColorH = [0, 0, 0];
        let quadriColorV = [255, 255, 255];
        let quadriTypeH = 0; // false
        let quadriTypeV = 0; // false

        let automergeBool= 0; // true
        let automergeShift= 50;


        $('.view').empty();
        $('.creation img').each(function(){
            imgValues.push($(this).attr('src'));
                }
        );
        $('.view').append('<img src="data/imgSite/loader.gif">');
        $.ajax({
            url: "src/model/mixinImagesModel.php",
            type: "POST",
            data: 
                { 
                    imgValues: imgValues,
                    pixelise: 
                    {
                        bool: pixeliseBool,
                        incrementX: pixelIncrementX,
                        incrementY: pixelIncrementY,
                        divider: pixelDivider,
                        operator: pixelOperator,
                        orientationX: pixelOrientationX,
                        orientationY: pixelOrientationY
                    },
                    quadrillage : 
                    {
                        bool: quadrillageBool,
                        H: quadrillageH,
                        V: quadrillageV,
                        incrementX: quadriPixelIncrementX,
                        incrementY: quadriPixelIncrementY,
                        thickH: quadriThickH,
                        thickV: quadriThickV,
                        colorRandom: quadriColorRandomBool,
                        colorH: quadriColorH,
                        colorV: quadriColorV,
                        typeH: quadriTypeH,
                        typeV: quadriTypeV
                    },
                    automerge:{
                        bool: automergeBool,
                        shift: automergeShift
                    }
                },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('.view').empty();
                $(".view").append(data.responseText);
                for (let i = 0; i < data.length; i++) {
                    $('.view').prepend(
                        '<img itemid="img-' + data[i] + '" class="theCreatedImages" src="data/imagesCreated/' + data[i] + '" alt="no image">'
                    );
                }
                $('.theCreatedImages').css({ 'width': '50%' });
            },
            error: function (error) {
                $('.view').empty();
                $(".view").append(error.responseText);
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
        );
    })

    $('section').on('click', '.theCreatedImages', function () {
        $('.modifyImage').css({ 'display': 'block' });
        $('#imgDisplay').html(
            '<img class="theImages" src="' + $(this).attr('src') + '" alt="no image">'
        );
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

    function rand(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
});
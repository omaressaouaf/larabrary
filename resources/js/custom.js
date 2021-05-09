const {
    unset
} = require("lodash");


$(window).on('load', function () {
    /*------------------
    	Preloder
    --------------------*/
    $(".loader").fadeOut();
    $("#preloder").delay(400).fadeOut("slow");

});
$(document).ready(function () {
    //  ________________________________________Animation and Css and Plugins________________________________________
    //initsializing data toggle
    $("[data-toggle='tooltip']").tooltip();
    //Toastr options config
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }



    // Collapse Navbar
    var navbarCollapse = function () {

        if ($("#mainNav").offset().top > 100) {
            $("#mainNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
        }


    };
    var mainNav = $("#mainNav");
    if (mainNav.length) {
        // Collapse now if page is not at top
        navbarCollapse();

        // Collapse the navbar when page is scrolled
        $(window).scroll(navbarCollapse);
    }


    // Fly to Cart Animation
    function flyToElement(flyer, flyingTo) {
        var $func = $(this);
        var divider = 3;
        var flyerClone = $(flyer).clone();
        $(flyerClone).css({
            position: 'absolute',
            top: $(flyer).offset().top + "px",
            left: $(flyer).offset().left + "px",
            opacity: 1,
            'z-index': 1000
        });
        $('body').append($(flyerClone));
        var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width() / divider) / 2;
        var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height() / divider) / 2;

        $(flyerClone).animate({
                opacity: 0.4,
                left: gotoX,
                top: gotoY,
                width: $(flyer).width() / divider,
                height: $(flyer).height() / divider
            }, 700,
            function () {
                $(flyingTo).fadeOut('fast', function () {
                    $(flyingTo).fadeIn('fast', function () {
                        $(flyerClone).fadeOut('fast', function () {
                            $(flyerClone).remove();
                        });
                    });
                });
            });
    }
    // _____________________________________________________Ajax Calls_______________________________________________________________
    // --------------------------------Cart---------------------------------------------------

    //Update Cart Quanity
    let quantityDropdown = $('.quantity');
    for (let i = 0; i < quantityDropdown.length; i++) {
        quantityDropdown[i].addEventListener("change", function () {

            let id = quantityDropdown[i].getAttribute('data-id');

            axios.patch(`/cart/${id}`, {
                    quantity: this.value
                })
                .then(function (response) {

                    window.location.href = '/cart';
                })
                .catch(function (error) {

                    window.location.href = '/cart';

                })
        })
    }



    //Refresh the cart count on the navbar
    function refreshCartCount() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/cart/count",
            method: "get",
            data: {

            },
            success: function (response) {
                $('#cartCountSpan').html(response['count']);


            },
            error: function (error) {
                console.log(error)
            }
        })
    }


    // Add book to cart 
    $(document).on('submit', '.addToCartForm', function (e) {

        e.preventDefault();
        $(this).find('.addToCartBtn').blur();


        var book_id = $(this).find('.book_id').val();
        var itemImg = $(this).parent().parent().find('img').eq(0);


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/cart",
            method: "post",
            data: {
                id: book_id
            },
            success: function (response) {
                toastr.clear();
                if (response['status'] == 1) {

                    toastr["success"]('<h6>' + response['message'] + '</h6>');
                    flyToElement(itemImg, $('#cartNav'));
                    setTimeout(function () {

                        $('#cartCountSpan').html(Number($('#cartCountSpan').html()) + 1);

                    }, 900);


                } else {

                    toastr["error"]('<h6>' + response['message'] + '</h6>');
                }

            },
            error: function (error) {
                console.log(error)
            }
        })
    })


    // --------------------------------Library----------------------------------------------------------

    // AutoComplete search
    $(document).mouseup(function (e) {
        var searchAutoForm = $("#searchAutoForm");
        // If the target of the click isn't the container
        if (!searchAutoForm.is(e.target) && searchAutoForm.has(e.target).length === 0) {
            $('.searchAutoDiv').hide();
        } else {
            if ($('#search_query').val().length > 2) {
                $('.searchAutoDiv').show();
            }
            
        }
    });
    $('')
    $(document).on('keyup', "#search_query", function () {
        var searchQuery = $(this).val();
        if (searchQuery.length > 2) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/library/search',
                method: 'get',
                data: {
                    search_query: searchQuery,
                    auto: true
                },
                dataType: 'json',
                success: function (response) {
                    $('.searchAutoDiv').html('')
                    $('.searchAutoDiv').show()
                    $('.searchAutoDiv').html(response);
                },
                error: function (error) {
                    console.log(error);
                }

            })
        } else {
            $('.searchAutoDiv').html('')
        }


    })


    //instant Search and Pagination without reloading the page
    function getSearchResults(page, price) {
        var searchInput = $("#searchInput").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/library/search?page=" + page + '&price=' + price,
            method: "get",
            data: {
                search_query: searchInput,

            },
            dataType: 'json',
            beforeSend: function () {
                $("#booksDiv").html('');
                $("#booksDiv").append("<img class='img-fluid' src='/storage/images/design/random/loader.gif'></img>");
            },
            success: function (response) {
                $("#booksDiv").html('');
                $("#booksDiv").append(response);
            },
            error: function (response) {
                console.log(response);
            }
        })


    }
    var searchTimeout;
    $(document).on('keyup', '#searchInput', function () {
        var price = window.location.href.split('price=')[1];
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        searchTimeout = setTimeout(function () {
            if ($("#searchInput").val().length > 2) {
                getSearchResults(1, price);
            }
        }, 1000);
    })

    $(document).on('click', '#resultsPagination .pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var price = $(this).attr('href').split('price=')[1];
        getSearchResults(page, price);

    });





})

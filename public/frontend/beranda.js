$(document).ready(function() {
    var calcDataTableHeight = function(){
        return $(window).height()*60/100;
    }

    //datatables
    table = $('#dt-legalitas').DataTable({
        "destroy"         : true,
        "draw"            : false,
        "deferRender"     : true,
        "LengthChange"    : true,
        "paginate"        : true,
        "pageResize"      : true,
        language : {
            sSearch     : "<i class='fa fa-search'></i>",
            sSearchPlaceholder: "Pencarian...",
            "emptyTable": "Tidak ada Data yang dapat ditampilkan..",
            "info"      : "Menampilkan _END_ dari _TOTAL_ entri.",
            "infoEmpty" : "Menampilkan 0 - 0 dari 0 entri.",
            "infoFiltered": "",
            sProcessing : "<span class='text-center'><img src='../../../img/loading-datatable.gif' class='img-responsive'><br/>Mohon tunggu, kami sedang menyiapkan data...</span>",
            sZeroRecords: "Tidak ada Data yang dapat ditampilkan..",
            sLengthMenu : "Tampilkan _MENU_",
            "paginate" : {
                "previous"    : "Sebelumnya",
                "next"        : "Selanjutnya"
            }
        },
        "fnDrawCallback": function (settings, display) {
            $('.ttp').tooltip();
        }
    });

    $("#btn-daftarshow").on("click", function () {
        $("#col-btndaftar").addClass("hide");
        $("#col-formdaftar").removeClass("hide");
    });

    // Select all links with hashes
    $('a[href*="#"].div_scroll')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
        // On-page links
        if (
            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
            &&
            location.hostname == this.hostname
        ) {
            // Figure out element to scroll to
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            // Does a scroll target exist?
            if (target.length) {
                // Only prevent default if animation is actually gonna happen
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000, function() {
                    // Callback after animation
                    // Must change focus!
                    var $target = $(target);
                    $target.focus();
                    if ($target.is(":focus")) { // Checking if the target was focused
                        return false;
                    } else {
                        $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                        $target.focus(); // Set focus again
                    };
                });
            }
        }
    });

    $('#hp').mask('000000000000');
    $('#nik').mask('0000000000000000');
    $('#nik_waris').mask('0000000000000000');
    $('#hp_waris').mask('000000000000');

    //mask rupiah
    //$('#nilai_santunan').maskMoney({thousands:'.', decimal:',', precision:0});

    // delegate calls to data-toggle="lightbox"
    $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
        event.preventDefault();
        return $(this).ekkoLightbox({
            onShown: function() {
                if (window.console) {
                    return console.log('Checking our the events huh?');
                }
            },
            onNavigate: function(direction, itemIndex) {
                if (window.console) {
                    return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
                }
            }
        });
    });

    //Open Foto Album
    $('#open-image').click(function(e) {
        e.preventDefault();
        $(this).ekkoLightbox();
    });

    // navigateTo
    $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
        event.preventDefault();
        var lb;
        return $(this).ekkoLightbox({
            onShown: function() {
                lb = this;
                $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                    e.preventDefault();
                    lb.navigateTo(2);
                });
            }
        });
    });


    //owl carousel
    $("#owl-slider").owlCarousel({
        navigation      : false, // Show next and prev buttons
        pagination      : false,
        dots            : false,
        slideSpeed      : 300,
        paginationSpeed : 400,
        autoplay        : true,
        autoplayHoverPause : true,
        loop            : false,
        stopOnHover     : true,
        items           : 1,
        // itemsDesktop : false,
        // itemsDesktopSmall : false,
        // itemsTablet: false,
        // itemsMobile : false
    });

    /*========================
        breaking news
    ==========================*/
    if ($('#breaking_news').length > 0) {
        $('#breaking_news').owlCarousel({
            items       : 1,
            loop        : false,
            stopOnHover : true,
            pagination  : false,
            navigation  : false,
            animateOut  : 'slideOutDown',
            animateIn   : 'fadeInRight',
            slideSpeed  : 800,
            //autoPlay    : 3000,
            autoplay    :true,
            autoplayTimeout: 8000,
            autoplayHoverPause : true
        });
    }

    /**************
    IN-blog post
    **************/
    $("#profilAnakAsuh-carousel").owlCarousel({
        nav               : true,// Show next and prev buttons
        pagination        : false,
        dots              : false,
        slideSpeed        : 300,
        paginationSpeed   : 400,
        items             : 3,
        autoplay          : true,
        autoplayHoverPause: true,
        loop              : false,
        stopOnHover       : true,
        responsive        : {
            0:{
                items:1
            },
            480:{
                items:1
            },
            700:{
                items:2
            },
            1000:{
                items:3
            },
            1100:{
                items:3
            }
        }
    });
    $('#profilAnakAsuh-carousel').find('.owl-prev').html('<i class="mdi mdi-chevron-double-left"></i>');
    $('#profilAnakAsuh-carousel').find('.owl-next').html('<i class="mdi mdi-chevron-double-right"></i>');

    $("#kegiatan-carousel").owlCarousel({
        nav                 :true,// Show next and prev buttons
        pagination          : false,
        dots                : false,
        slideSpeed          : 300,
        paginationSpeed     : 400,
        items               : 3,
        autoplay            : true,
        autoplayHoverPause  : true,
        loop                : false,
        stopOnHover         : true,
        responsive          :{
            0:{
                items:1
            },
            480:{
                items:1
            },
            700:{
                items:2
            },
            1000:{
                items:3
            },
            1100:{
                items:3
            }
        }
    });
    $('#kegiatan-carousel').find('.owl-prev').html('<i class="mdi mdi-chevron-double-left"></i>');
    $('#kegiatan-carousel').find('.owl-next').html('<i class="mdi mdi-chevron-double-right"></i>');
    
    $("#provider-carousel").owlCarousel({
        nav                 :false,
        pagination          : false,
        dots                : false,
        slideSpeed          : 30,
        paginationSpeed     : 30,
        items               : 3,
        autoplay            : true,
        autoplayHoverPause  : true,
        loop                : false,
        stopOnHover         : true,
        responsive          :{
            0:{
                items:1
            },
            480:{
                items:1
            },
            700:{
                items:2
            },
            1000:{
                items:3
            },
            1100:{
                items:3
            }
        }
    });
    $('#provider-carousel').find('.owl-prev').html('<i class="mdi mdi-chevron-double-left"></i>');
    $('#provider-carousel').find('.owl-next').html('<i class="mdi mdi-chevron-double-right"></i>');

    $("#kegiatan-lainnya").owlCarousel({
        nav                 :false,
        pagination          : false,
        dots                : true,
        autoplayTimeout     : 4000,
        items               : 3,
        autoplay            : true,
        margin              : 1,
        autoplayHoverPause  : true,
        loop                : true,
        stopOnHover         : true,
        responsive          :{
            0:{
                items:1
            },
            480:{
                items:1
            },
            700:{
                items:2
            },
            1000:{
                items:4
            },
            1100:{
                items:4
            }
        }
    });
    $('#kegiatan-lainnya').find('.owl-prev').html('<i class="mdi mdi-chevron-double-left"></i>');
    $('#kegiatan-lainnya').find('.owl-next').html('<i class="mdi mdi-chevron-double-right"></i>');

    jQuery(document).ready(function($) {
        $('#providers').owlCarousel({
            autoplayTimeout     : 3000,
            items               : 3,
            autoplay            : true,
            center              : true,
            items               : 2,
            loop                : true,
            margin              : 10,
            responsive: {
            0: {
                items: 4,
                pagination          : false,
                dots                : false,
            },
            600: {
                items: 4
                
            }
            }
        });
    });

    jQuery(document).ready(function($) {
        $('#link_survey').owlCarousel({
            autoplayTimeout     : 3000,
            items               : 10,
            autoplay            : false,
            center              : false,
            items               : 2,
            loop                : false,
            margin              : 10,
            responsive: {
            0: {
                items: 4,
                pagination          : false,
                dots                : false,
            },
            600: {
                items: 4
            }
            }
        });
    });

    // Swal.fire(
    //     'Good job!',
    //     'You clicked the button!',
    //     'success'
    // )
});

//Get umur
function getAge(DOB) {
    var today = new Date();
    var birthDate = new Date(DOB);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    /*if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age = age - 1;
    }
    */
    if (m > 1 || (m === 1 && today.getDate() > birthDate.getDate())) {
        age = age + 1;
    }
    //alert(m);
    return age;
}

//Validate Email
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$('#list-legalitas').click(function(e){
    $('#dt-legalitas').css('width', '100%');
    $('#dt-legalitas').DataTable().columns.adjust().draw();
});

/*************************
    Upload File Gambar
*************************/
// $("#foto_ktpkk").fileinput({
//     maxFileSize: 2048,
//     language: "id",
//     showUpload: false,
//     browseClass: "btn btn-raised btn-primary",
//     browseLabel: "Cari File",
//     msgPlaceholder: "File wajib berupa KTP bukan KK...",
//     showPreview: false,
//     showCancel: false
// });
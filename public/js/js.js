$(document).ready(function() {
  $('html,body').scrollTop(0); //przeniesienie na górę po otwarniu nowej karty

  $(function () {
      var lastScrollTop = 0;
      $(window).scroll(function(event){
         var st = $(this).scrollTop();
         var element = document.getElementById("nav");
         if (st > lastScrollTop){
           $('nav').fadeOut();
         }
         else {
            $('nav').fadeIn();
         }
         lastScrollTop = st;
      });
      return false;
  });

  function noscroll() {//wyłączenie scrolla
    window.scrollTo( 0, 0 );
  }

  $('ul.pagination').hide();
  $(window).scroll(function () {
      $('.infinite-scroll').jscroll({
                  autoTrigger: true,
                  debug: true,
                  loadingHtml: '<div class="text-center"><img class="center-block" src="/img/Spinner.svg" alt="Loading..." /></div>',
                  padding: 10,
                  nextSelector: '.pagination li.active + li a',
                  contentSelector: '.infinite-scroll',
                  callback: function() {
                      $('ul.pagination').remove();
                    }
            });
        });

        $(function () {
            $('.normal_url_pagination ul.pagination').show();
        });

  $("form").submit(function(){//wyświetlenie loadera po przesłaniu formularza dodawania i edycji
      $('html,body').scrollTop(0);
      $(".page_loader_div").addClass("page_loader");
      $('.page_loader').fadeIn();
      window.addEventListener('scroll', noscroll);
    });

    $(function () {
        $("#reloader").click(function(){//fukcja zerująca licznik powiadomień
          $("#notifyReload").load(" #notifyReload");//odświeżenie listy powiadomień
          $("#zero").load("/zero");//wyzerowanie licznika
          $("#counter").load(" #counter");//odświeżenie liczby licznika
        });

        setInterval( RefreshCounter, 3000 );//odświeżenie co 3sekund
        function RefreshCounter()
        {
          $("#counter").load(" #counter");//odświeżenie liczby licznika
        }
    });

    $(".search_app input").focus(function(){
      $(".search_app i").addClass("fa_color");
    }).blur(function(){
        $(".search_app i").removeClass("fa_color");
      });
    $(".search_admin input").focus(function(){
      $(".search_admin i").addClass("fa_color");
    }).blur(function(){
        $(".search_admin i").removeClass("fa_color");
      });

  $(function () {
      var lastScrollTop = 0;
      $(window).scroll(function(event){
         var st = $(this).scrollTop();
         var element = document.getElementById("nav");
         if (st > lastScrollTop){
           $('.error_div').fadeOut();
         }
         else {
            $('.error_div').fadeIn();
         }
         lastScrollTop = st;
      });
      return false;
  });
  $(function () {
      $(window).scroll(function () {
          if ($(this).scrollTop() > 25)
          {
              $('.buttonMail').fadeIn();
          }
          else
          {
              $('.buttonMail').fadeOut();
          }
      });
  });

  $(function () {
        setTimeout(function(){
          $('.error_div').fadeOut();
          $(".error_div").addClass("d-none");
        }, 3000);
  });
//admin panel:
       $(".change-role").click(function(e) {
         var currentUserRole = $(this).data("user_role"); //aktualna ranga użytkownika
         var currentUserId = $(this).data("user_id");
         $("input[name='user_id']").val(currentUserId); // dodanie id użytkownika do przesyłanych danych
         $("select[name='role']").val(currentUserRole); // wybierz rangę użytkownika
         $("#role").modal("show");
       });

//kroki:
       $(function () {
         $('.tab_content').hide();
         $('.tab_content:first').show();
         $('.tabs li:first').addClass('active');
         $('.tabs li').click(function(event) {
           $('.tabs li').removeClass('active');
           $(this).addClass('active');
           $('.tab_content').hide();
           var selectTab = $(this).find('button').attr("href");
           $(selectTab).fadeIn();
         });
       });

       $(function () {
         $('.steps_animate').click(function () {
             $('html, body').animate({
                  scrollTop:$("#steps_animate").offset().top-10
             }, 900);
         });
         return false;
       });

//summernote:
       $('#summernote_textarea').summernote
       ({
         height: 300,//wysokoś początkowa okna do wpisania treści
         lang: 'pl-PL',//zmiana języka na polski
         placeholder: 'Napisz coś...',
         toolbar:
         [
            // [groupName, [list of button]]
            ['style', ['style']], //zmiana stylu
            ['style', ['bold', 'italic', 'underline', 'clear', 'fontsize']], //pogrubienie, pochylenie, podkreślenie, usuń formatowanie, rozmiar czcionki
            ['color', ['color']],// kolor czcionki i tła
            ['hr', ['hr']],//wstawienie poziomej linii
            ['para', ['ol', 'paragraph']],//lista numerowana, akapit
            ['picture', ['picture']],//obraz
            ['link', ['link']],//link
            ['video', ['video']],//wideo
            ['table', ['table']],//tabela
            ['fullscreen', ['fullscreen']],// pełny ekran
            ['undo',['undo', 'redo']]// wstecz ,w przód
        ]
      });

      $(function () {
          $(window).scroll(function () {
              if ($(this).scrollTop() > 25)
              {
                  $('.buttonMail').fadeIn();
              }
              else
              {
                  $('.buttonMail').fadeOut();
              }
          });
      });
//przycisk przenoszący do góry
      $(function () {
          $(window).scroll(function () {
              if ($(this).scrollTop() > 25)
              {
                  $('.buttonTop').fadeIn();
              }
              else
              {
                  $('.buttonTop').fadeOut();
              }
          });

          $('.buttonTop').click(function () {
              $('html, body').animate({
                  scrollTop: 0
              }, 900);
          });
          return false;
      });

      Barba.Pjax.start();
      Barba.Dispatcher.on('newPageReady', function() {
        $(".search_admin input").focus(function(){
          $(".search_admin i").addClass("fa_color");
        }).blur(function(){
            $(".search_admin i").removeClass("fa_color");
          });

        $('#summernote_textarea').summernote
        ({
          height: 300,//wysokoś początkowa okna do wpisania treści
          lang: 'pl-PL',//zmiana języka na polski
          placeholder: 'Napisz coś...',
          toolbar:
          [
             // [groupName, [list of button]]
             ['style', ['style']], //zmiana stylu
             ['style', ['bold', 'italic', 'underline', 'clear', 'fontsize']], //pogrubienie, pochylenie, podkreślenie, usuń formatowanie, rozmiar czcionki
             ['color', ['color']],// kolor czcionki i tła
             ['hr', ['hr']],//wstawienie poziomej linii
             ['para', ['ol', 'paragraph']],//lista numerowana, akapit
             ['picture', ['picture']],//obraz
             ['link', ['link']],//link
             ['video', ['video']],//wideo
             ['table', ['table']],//tabela
             ['fullscreen', ['fullscreen']],// pełny ekran
             ['undo',['undo', 'redo']]// wstecz ,w przód
         ]
       });

       //admin panel:
              $(".change-role").click(function(e) {
                var currentUserRole = $(this).data("user_role"); //aktualna ranga użytkownika
                var currentUserId = $(this).data("user_id");
                $("input[name='user_id']").val(currentUserId); // dodanie id użytkownika do przesyłanych danych
                $("select[name='role']").val(currentUserRole); // wybierz rangę użytkownika
                $("#role").modal("show");
              });

       $('ul.pagination').hide();
       $(window).scroll(function () {
           $('.infinite-scroll').jscroll({
                       autoTrigger: true,
                       debug: true,
                       loadingHtml: '<div class="text-center"><img class="center-block" src="/img/Spinner.svg" alt="Loading..." /></div>',
                       padding: 10,
                       nextSelector: '.pagination li.active + li a',
                       contentSelector: '.infinite-scroll',
                       callback: function() {
                           $('ul.pagination').remove();
                         }
                 });
             });

             $(function () {
                 $('.normal_url_pagination ul.pagination').show();
             });

            $(function () {
               var x = document.getElementById("video-player");
               if (x)
               {
                  videojs(document.querySelector('#video-player'))
               }
            });

            $(function () {
              $('.tab_content').hide();
              $('.tab_content:first').show();
              $('.tabs li:first').addClass('active');
              $('.tabs li').click(function(event) {
                $('.tabs li').removeClass('active');
                $(this).addClass('active');
                $('.tab_content').hide();
                var selectTab = $(this).find('button').attr("href");
                $(selectTab).fadeIn();
              });
            });

            $(function () {
              $('.steps_animate').click(function () {
                  $('html, body').animate({
                       scrollTop:$("#steps_animate").offset().top-10
                  }, 900);
              });
              return false;
          });

            $(function () {
                var lastScrollTop = 0;
                $(window).scroll(function(event){
                   var st = $(this).scrollTop();
                   var element = document.getElementById("nav");
                   if (st > lastScrollTop){
                     $('.error_div').fadeOut();
                   }
                   else {
                      $('.error_div').fadeIn();
                   }
                   lastScrollTop = st;
                });
                return false;
            });

            $(function () {
                  setTimeout(function(){
                    $('.error_div').fadeOut();
                    $(".error_div").addClass("d-none");
                  }, 3000);
            });

      });

});

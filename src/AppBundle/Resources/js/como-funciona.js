$(document).ready(function(){
    //Chamada Slider
    $('.slider').slider();

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();

    // Chamada select destinos
    $('select').material_select();

    $('#highlight_0').css({"border":"3px solid #ff4242"});
    $('#idInfo_0_detail').show(); 


    $('#highlight_0').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_0_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_0_detail').hide();
        }
    );

    $('#highlight_1').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_1_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_1_detail').hide();
        }
    );
    $('#highlight_2').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_2_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_2_detail').hide();
        }
    );
    $('#highlight_3').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_3_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_3_detail').hide();
        }
    );
    $('#highlight_4').hover(
        function () {
            $(this).css({"border":"3px solid #ff4242"});
            $('#idInfo_4_detail').show();
        },

        function () {
            $(this).css({"border":"none"});
            $('#idInfo_4_detail').hide();
        }
    );
});

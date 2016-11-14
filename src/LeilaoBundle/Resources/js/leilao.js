
var BidTravel = BidTravel || {};

BidTravel.Leilao = {
    timer : null,

    startTimerDown: function (element) {
        $(element).timer('remove');
        $(element).timer({
            countdown: true,
            duration: BidTravel.Leilao.timer,
            format: '%H:%M:%S'
        });
    },

    darLance: function (element) {
        var url = $(element).attr("href");

        $.ajax({
            url: url,
            type: "get",
            success: function(data) {
                BidTravel.Leilao.startLiveLeilao();
            },
            error: function(){

            },
        });
    },
    
    startLiveLeilao: function () {
        var url = $("#leilaoLive").attr("rel");
        $.ajax({
            url: url,
            type: "get",
            success: function(data) {
                $.each(data, function() {
                    var idLeilao = this.idLeilao;
                    var elementleilao = $("#leilao"+idLeilao);

                    if (this.lances != null) {
                        var elementLances = $('.lancesLeilao', elementleilao);
                        var elementTimer = $('.timersLeilao', elementleilao);
                        $(elementLances).html('');
                        $.each(this.lances, function() {
                            $(elementLances).append('<p>R$ ' + this.valor + ' - ' + this.usuarioNome + '</p>');
                        });

                    }

                    BidTravel.Leilao.timer = this.timer;

                    if (this.timer != null) {
                        BidTravel.Leilao.startTimerDown(elementTimer);
                    }
                });
            },
            error: function(){

            }
        });


        /** setInterval(function () {
            if (!sending) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: {dereck:'dereck'},
                    beforeSend: function() {
                        sending = true;
                    },
                    success: function(data) {
                        console.log(data);
                        sending = false;
                    },
                    error: function(){
                        sending = false;
                    },
                    complete: function(data) {
                        sending = false;
                    },
                });
            }
        }, 15000);
         */
    }
}

jQuery(document).ready(function($) {
    BidTravel.Leilao.startLiveLeilao();

    $(".darLance").on('click', function () {
        BidTravel.Leilao.darLance(this);

        return false;
    });
})
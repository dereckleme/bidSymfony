
var BidTravel = BidTravel || {};

BidTravel.Leilao = {
    timer : null,
    showLances: true,

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
                    var valorAtual = this.valorAtual;
                    var valorEconomia = this.valorEconomia;
                    var desconto = this.desconto;
                    var usuarioAtual = this.usuarioAtual;

                    if (this.lances != null) {
                        var elementLances = $('.lancesLeilao', elementleilao);
                        $(elementLances).html('');
                        $.each(this.lances, function() {
                            $(elementLances).append('<p>R$ ' + this.valor + ' - ' + this.usuarioNome + '</p>');
                        });

                    }

                    BidTravel.Leilao.timer = this.timer;

                    if (this.timer != null) {
                        var elementTimer = $('.timersLeilao', elementleilao);
                        BidTravel.Leilao.startTimerDown(elementTimer);
                    }

                    $('.valorAtual', elementleilao).html(valorAtual);
                    $('.valorEconomia', elementleilao).html(valorEconomia);
                    $('.desconto', elementleilao).html(desconto);
                    $('.usuarioAtual', elementleilao).html(usuarioAtual);
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

$(function() {
    setInterval(function () {
    BidTravel.Leilao.startLiveLeilao();
    }, 2000);

    $(".darLance").on('click', function () {
        BidTravel.Leilao.darLance(this);

        return false;
    });
})
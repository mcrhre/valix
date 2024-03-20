/* jshint unused:false*/
/* jshint shadow:true */
/* exported formValidationSetup, refreshErrorMessages */
/*jshint loopfunc: true */

$(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1500);
                return false;
            }
        }
    });
    var erro = getAllUrlParams().erro;
    if (erro == 1) {
        swal("", "Usuário ou senha incorretos!", "error");
    }
});

function clear_number(val) {
    var val = val.replace('.', '');
    var val = val.replace('-', '');
    var val = val.replace('/', '');
    return val;
}

$(document).ready(function() {
    $('#receber_aviso_periodo').change(function(){
        if($(this).prop('checked')){
            $('.periodico').css('opacity','1');
            $('.periodico').css('pointer-events','all');
            $('.periodico label').css('pointer-events','all');
            $('.periodico input').css('pointer-events','all');
            $('.periodico select').css('pointer-events','all');
            $('.periodico input').removeAttr('readonly','readonly');
            $('.periodico select').removeAttr('readonly','readonly');
        } else {
            $('.periodico').css('opacity','0.4');
            $('.periodico').css('pointer-events','none');
            $('.periodico label').css('pointer-events','none');
            $('.periodico input').css('pointer-events','none');
            $('.periodico select').css('pointer-events','none');
            $('.periodico input').attr('readonly','readonly');
            $('.periodico select').attr('readonly','readonly');
        }
    });
    $("#cep").blur(function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $("#endereco").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
                $("#bairro").val("...");
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                    } else {
                        $("#endereco").val("");
                        $("#bairro").val("");
                        $("#cidade").val("");
                        $("#estado").val("");
                        $("#cep").val("");
                        swal('', 'Cep não encontrado!', 'warning');
                    }
                });
            } else {
                $("#endereco").val("");
                $("#cidade").val("");
                $("#estado").val("");
                $("#bairro").val("");
                $("#cep").val("");
                alert("Formato de CEP inválido.");
                swal('', 'Cep invalido!', 'warning');
            }
        } else {
            $("#endereco").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#estado").val("");
            $("#cep").val("");
        }
    });
    $('.documento').keydown(function() {
        Mascara(this, CpfCnpj);
    });
    $('#checkbox1').prop('checked', true);
    $('#checkbox2').prop('checked', true);
    $('#checkbox4').prop('checked', true);
    $('#checkbox7').prop('checked', true);
    $('#checkbox8').attr('checked', true);
    $('input[name=relatorio]').change(function() {
        var checked = $('input[name=relatorio]:checked').val();
        var checked = Number(checked);
        for (var i = 1; i <= 20; i++) {
            $('#checkbox' + i).prop('checked', false);
        }
        if (checked == 1) {
            $('#checkbox1').prop('checked', true);
            $('#checkbox2').prop('checked', true);
            $('#checkbox4').prop('checked', true);
            $('#checkbox7').prop('checked', true);
            $('#checkbox8').attr('checked', true);
        } else {
            for (var i = 1; i <= 20; i++) {
                $('#checkbox' + i).prop('checked', true);
            }
        }
    });
    $('input[data-masker=alphanumeric]').keypress(function(e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
    $('input[data-masker=maxnumber]').keypress(function(e) {
        var value = Number($(this).val());
        var max = Number($(this).data('max'));
        $(this).val(minmax(value, 1, max));
    });
    $('textarea[data-masker=alphanumeric]').keypress(function(e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;
    });
    setTimeout(function() { $('#loader').fadeOut(); }, 0);
    $(".menuItem").click(function() {
        var url = $(this).data('href');
        location.href = '.?page=' + url;
    });
    $("#enableLeftMenu").click(function() {
        $('#colLeftMenu').toggleClass('hidden-sm-down');
        $('#colMainMenu').toggleClass('col-lg-10');
        $('#colMainMenu').toggleClass('col-md-10');
        $('#colMainMenu').toggleClass('col-sm-12');
        $('#colMainMenu').toggleClass('col-xs-9');
        $('#colMainMenu').toggleClass('col-lg-12');
        $('#colMainMenu').toggleClass('col-md-12');
        $('#colMainMenu').toggleClass('col-sm-10');
        $('#colMainMenu').toggleClass('col-xs-12');
    });
    $("#enableLeftMenu").click(function() {
        $('#produtoNome').focus();
    });
    $("#produtoNome").focus(function() {
        $('#formDados').fadeIn('slow');
        $('#formExtra').fadeIn('slow');
    });
    $('#addExtraInfo').click(function() {
        $('#formExtra2').show();
        $(this).hide();
        $('#hideExtraInfo').show();
    });
    $('#hideExtraInfo').click(function() {
        $('#formExtra2').hide();
        $(this).hide();
        $('#addExtraInfo').show();
    });
    $('#cancelarNovoProduto').click(function() {
        cancelarProdutoNovo();
    });
    $('#novaMarca').bind('blur', function() {
        if ($('#novaMarca').val() === '') {
            $('#marcaTrNova').hide();
        }
    });
    $('#novaCategoria').bind('blur', function() {
        if ($('#novaCategoria').val() === '') {
            $('#categoriaTrNova').hide();
        }
    });
    $('#novaCategoriasub').bind('blur', function() {
        if ($('#novaCategoria').val() === '' && $('#novaCategoriasub').val() === 0) {
            $('#subcategoriaTrNova').hide();
        }
    });
    $('#novaUnidadeMedida').bind('blur', function() {
        if ($('#novaUnidadeMedida').val() === '') {}
    });
    $('#novaFornecedor').bind('blur', function() {
        if ($('#novaFornecedor').val() === '') {
            $('#fornecedorTrNova').hide();
        }
    });
    $('#novaCategoriasub').bind('blur', function() {
        if ($('#novaFornecedor').val() === '') {
            $('#fornecedorTrNova').hide();
        }
    });
    $("#inputPesquisa").on('input', function(e) {
        var text = $(this).val();
        if (text) {
            $('#limparPesquisa').fadeIn();
        } else {
            $('#limparPesquisa').fadeOut();
        }
    });
    $(document).ready(function() {
        $('.datepicker1').pickadate({
            today: '',
            clear: '',
            close: 'Fechar',
            format: 'dd/mm/yyyy',
            selectYears: 60,
            min: $('#menorData').val(),
            max: $('#maiorData').val()
        });
    });
});

$(document).keyup(function(e) {
    if (e.keyCode == 27) {
        if ($('#novaMarca').is(':focus') === true && $('#novaMarca').val()) {
            $('#marcaTrNova').hide();
        }
        if ($('#novaCategoria').is(':focus') === true && $('#novaCategoria').val()) {
            $('#categoriaTrNova').hide();
        }
        if ($('#novaSubcategoria').is(':focus') === true && $('#novaSubcategoria').val() && $('#novaCategoriasub').val() === 0) {
            $('#subcategoriaTrNova').hide();
        }
        if ($('#novaUnidadeMedida').is(':focus') === true && $('#novaUnidadeMedida').val()) {
            $('#unidade_medidaTrNova').hide();
        }
        if ($('#novaFornecedor').is(':focus') === true && $('#novaFornecedor').val()) {
            $('#fornecedorTrNova').hide();
        }
        $('input').blur();
    }
});


//Ajax Submit
function genericsubmit(target, text, outro = true) {
    //Alterar produto
    var target = '#' + target;
    var formData = $(target).serialize();
    var url = $(target).attr('action');
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false
    });
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function(data) {
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                if (outro)
                    swal({
                            title: "",
                            text: text + " salvo com sucesso. <br /> Deseja cadastrar outro?",
                            type: "success",
                            confirmButtonColor: "#b0e095",
                            confirmButtonText: "Sim, criar novo",
                            cancelButtonText: "Não, fechar",
                            cancelButtonColor: "#DD6B55",
                            showCancelButton: true,
                            html: true,
                            closeOnConfirm: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                swal.close();
                                novoProduto();
                            } else {
                                window.onbeforeunload = function() {};
                                window.location.reload();
                            }
                        });
                else
                    swal({
                            title: "",
                            text: text + " salvo com sucesso",
                            showCancelButton: false,
                            type: "success",
                            confirmButtonColor: "#b0e095",
                            html: true,
                            closeOnConfirm: false
                        },
                        function() {
                            window.onbeforeunload = function() {};
                            window.location.reload();
                        })
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        },
        error: function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        }
    });
}

function editItem(par) {
    $('#loader').fadeIn();
    var url = $(par).data('href');
    $('#modalEditContent').load(url);
}

function cancelEdit() {
    swal({
        title: "Você tem certeza?",
        text: "Não será possível desfazer a ação",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        window.onbeforeunload = function() {};
        window.location.reload();
    });
}

function newItem(par) {

}

function genericConfirm() {}

function excluirProduto(id) {
    swal({
        title: "Você tem certeza?",
        text: "O produto será excluido",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        var url = 'deletar/produto.php?id=' + id;
        $.ajax({
            url: url,
            success: function(data) {
                if (data) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        window.onbeforeunload = function() {};
                        window.location.reload();
                    });
                } else {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

var addEvent = function(object, type, callback) {
    if (object === null || typeof(object) == 'undefined') return;
    if (object.addEventListener) {
        object.addEventListener(type, callback, false);
    } else if (object.attachEvent) {
        object.attachEvent("on" + type, callback);
    } else {
        object["on" + type] = callback;
    }
};
addEvent(window, "resize", function(event) {
    if (window.innerWidth > 768) {
        $('#colMainMenu').addClass('col-lg-10');
        $('#colMainMenu').addClass('col-md-10');
        $('#colMainMenu').addClass('col-sm-12');
        $('#colMainMenu').addClass('col-xs-12');
        $('#colMainMenu').removeClass('col-lg-12');
        $('#colMainMenu').removeClass('col-md-12');
        $('#colMainMenu').removeClass('col-sm-10');
        $('#colMainMenu').removeClass('col-xs-9');
        $('#colLeftMenu').addClass('hidden-sm-down');
    }
});

function cancelarProdutoNovo() {
    swal({
        title: "Você tem certeza?",
        text: "Não será possível desfazer a ação",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        $('#formExtra').hide();
        $('#formExtra2').hide();
        $('.extraFormCol').hide();
        $('#produtoNome').val('');
        $('#hideExtraInfo').hide();
        $('#addExtraInfo').show();
    });
}

function novoProduto() {
    $.pgwModal({
        url: 'cadastrar/produto.php',
        loadingContent: '<center style="font-size:18px"><br /><br />Carregando <i class="fa fa-circle-o-notch fa-spin"></i><br /><br /></center>',
        title: 'Novo Produto',
        closable: false
    });
    $('body').css('overflow-y', 'hidden');
    window.onbeforeunload = confirmExit;
}

function confirmExit() {
    return "É possível que as alterações feitas não sejam salvas.";
}

function editarProduto(id) {
    $.pgwModal({
        url: 'alterar/produto.php?id=' + id,
        loadingContent: '<center style="font-size:18px"><br /><br />Carregando <i class="fa fa-circle-o-notch fa-spin"></i><br /><br /></center>',
        title: 'Produtos',
        closable: false
    });
    $('body').css('overflow-y', 'hidden');
    window.onbeforeunload = confirmExit;
}

function novaMarca2() {

    swal({
            title: "",
            text: "Adicione uma nova Marca",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Adicionar',
            animation: "slide-from-top",
            inputPlaceholder: "Nova Marca",
            showLoaderOnConfirm: true
        },
        function(inputValue) {
            if (inputValue === false) return false;

            if (inputValue === "") {
                swal.showInputError("Você precisa escrever a marca!");
                return false;
            }
            $.post("cadastrar/gravar_marca.php", { nome_marca: inputValue })
                .done(function(data) {
                    if (erroJSON(data.codigo) === 0) {
                        $('.alert-no-result').hide();
                        swal("", "A marca: " + inputValue + " foi adicionada com sucesso", "success");
                        var options;
                        $.getJSON('ajax/marca.php', { ajax: 'true' }, function(j) {
                            for (var i = 0; i < j.length; i++) {
                                options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
                            }
                            $('select#marca_produto').html("<option value='0'>Escolher</option>" + options);
                        });
                    } else {

                        swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                    }
                })
                .fail(function() {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                });
        });
}

function novaUnidadeMedida2() {
    swal({
            title: "",
            text: "Adicione uma nova Unidade/Medida",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Adicionar',
            animation: "slide-from-top",
            inputPlaceholder: "Nova Unidade/Medida",
            showLoaderOnConfirm: true
        },
        function(inputValue) {
            if (inputValue === false) return false;

            if (inputValue === "") {
                swal.showInputError("Você precisa escrever a Unidade/Medida!");
                return false;
            }
            $.post("cadastrar/gravar_unidade_medida.php", { nome_unidade_medida: inputValue })
                .done(function(data) {
                    if (erroJSON(data.codigo) === 0) {
                        $('.alert-no-result').hide();
                        swal("", "A Unidade/Medida: " + inputValue + " foi adicionada com sucesso", "success");
                        $('.itensFator').show();
                        $('#quantidade_fator').removeAttr('disabled');
                        var options;
                        $.getJSON('ajax/unidade_medida.php', { ajax: 'true' }, function(j) {
                            for (var i = 0; i < j.length; i++) {
                                options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
                            }
                            $('select#unidade_medida').html(options);
                        });
                    } else {

                        swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                    }
                })
                .fail(function() {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                });
        });
}

function novaCategoria2(par = 0, par2 = 0) {
    swal({
            title: "",
            text: "Adicione uma nova Categoria",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Adicionar',
            animation: "slide-from-top",
            inputPlaceholder: "Nova Categoria",
            showLoaderOnConfirm: true
        },
        function(inputValue) {
            if (inputValue === false) return false;

            if (inputValue === "") {
                swal.showInputError("Você precisa escrever a categoria!");
                return false;
            }
            $.post("cadastrar/gravar_categoria.php", { nome_categoria: inputValue })
                .done(function(data) {
                    var options;
                    var id = data.id;
                    if (erroJSON(data.codigo) === 0) {
                        $('.alert-no-result').hide();
                        swal("", "A categoria: " + inputValue + " foi adicionada com sucesso", "success");
                        //ajax
                        if (par) {
                            var categoriaVal = scapeString(inputValue);
                            var categoraVal = categoriaVal.toLowerCase();
                            var categoraVal = categoraVal.capitalize();
                            $('.categoriaSub').append("<option value=\"" + id + "\">" + categoraVal + "</option>");
                            $('#categoriaSub' + par2).val(id);
                        } else {
                            $.getJSON('ajax/categoria.php', { ajax: 'true' }, function(j) {
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
                                }
                                $('select#categoria_produto').html("<option value='0'>Escolher</option>" + options);
                                $('select#categoria_produto').val(id);
                                $.getJSON('ajax/subcategoria.php', {id_categoria: id, ajax: 'true'}, function(j){
                                    //se vier resposta adiciona na combo
                                    if(j.length){
                                        var options;
                                        
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
                                        }   
                                        $('select#subcategoria_produto').html("<option value='0'>Escolher</option>" + options).show().removeAttr('disabled');
                                        
                                    }else{
                                        $('select#subcategoria_produto').html("<option value='0'>Escolher</option>").attr('disabled','disabled');
                                    }   
                                });
                            });
                        }
                    } else {

                        swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                    }
                })
                .fail(function() {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                });
        });

}

function novaSubCategoria2() {
    if (Number($('#categoria_produto').val()) === 0) {
        swal('', 'Você precisa selecionar a categoria', 'warning');
        return false;
    }
    swal({
            title: "",
            text: "Adicione uma nova Sub Categoria",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Adicionar',
            animation: "slide-from-top",
            inputPlaceholder: "Nova Sub Categoria",
            showLoaderOnConfirm: true
        },
        function(inputValue) {
            if (inputValue === false) return false;

            if (inputValue === "") {
                swal.showInputError("Você precisa escrever a Sub Categoria!");
                return false;
            }
            var categoria = $('#categoria_produto').val();
            $.post("cadastrar/gravar_subcategoria.php", { nome_subcategoria: inputValue, categoria_produto: categoria })
                .done(function(data) {
                    var options;
                    if (erroJSON(data.codigo) === 0) {
                        $('.alert-no-result').hide();
                        swal("", "A Sub Categoria: " + inputValue + " foi adicionada com sucesso", "success");
                        //ajax
                        $.getJSON('ajax/subcategoria.php', { id_categoria: categoria, ajax: 'true' }, function(j) {
                            for (var i = 0; i < j.length; i++) {
                                options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
                            }
                            $('select#subcategoria_produto').html("<option value='0'>Escolher</option>" + options);
                        });
                        $('select#subcategoria_produto').removeAttr('disabled','disabled');
                    } else {

                        swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                    }
                })
                .fail(function() {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                });
        });
}

function novoFornecedor2() {

    swal({
            title: "",
            text: "Adicione um novo Fornecedor",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Adicionar',
            animation: "slide-from-top",
            inputPlaceholder: "Novo Fornecedor",
            showLoaderOnConfirm: true
        },
        function(inputValue) {
            if (inputValue === false) return false;

            if (inputValue === "") {
                swal.showInputError("Você precisa escrever o fornecedor!");
                return false;
            }
            $.post("cadastrar/gravar_fornecedor.php", { nome_fornecedor: inputValue })
                .done(function(data) {
                    var options;
                    if (erroJSON(data.codigo) === 0) {
                        $('.alert-no-result').hide();
                        swal("", "O Fornecedor: " + inputValue + " foi adicionado com sucesso", "success");
                        //ajax
                        $.getJSON('ajax/fornecedor.php', { ajax: 'true' }, function(j) {
                            for (var i = 0; i < j.length; i++) {
                                options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
                            }
                            $('select#fornecedor_produto').html("<option value='0'>Escolher</option>" + options);
                        });
                    } else {

                        swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                    }
                })
                .fail(function() {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                });
        });
}

function editarMarca(id) {
    var marca = $('#marcaNome' + id).html();
    var key = "onkeypress=\"$(this).val(aspas($(this).val()));\" onkeyup=\"$(this).val(aspas($(this).val()));\"";
    $('#marcaNome' + id).html("<input class=\"form-control input-sm\" " + key + " value=\"" + marca + "\" id=\"marcaInput" + id + "\" placehoder=\"Marca\" style=\"background: white;height: 25px !important;margin: 0;line-height: inherit !important;font-size: 14px;padding: 0;\" />");
    $('#marcaEditar' + id).hide();
    $('#marcaSalvar' + id).show();
    $('#marcaCancelar' + id).show();
}

function salvarMarca(id) {
    var marca = $('#marcaInput' + id).val();
    if (marca === '') {
        swal({ title: '', text: 'Você precisa preencher a marca', type: 'warning' });
        return false;
    }
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false
    });
    $.post("alterar/gravar_marca.php", { codigo_marca: id, nome_marca: marca })
        .done(function(data) {
            var options;
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                swal("", "Marca alterada com sucesso", "success");
                //ajax
                $('#marcaNome' + id).html(marca);
                $('#marcaEditar' + id).show();
                $('#marcaSalvar' + id).hide();
                $('#marcaCancelar' + id).hide();
                $('#marcaCancelar' + id).removeAttr('onclick');
                $('#marcaCancelar' + id).attr('onclick', 'cancelarMarca(' + id + ',\'' + scapeString(marca) + '\')');
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function excluirMarca(id) {
    swal({
        title: "Você tem certeza?",
        text: "A marca será excluida",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        swal({
            title: "",
            text: "Excluindo",
            imageUrl: "assets/img/loader.gif",
            showCancelButton: false,
            showConfirmButton: false
        });
        var url = 'deletar/marca.php?id=' + id;
        $.ajax({
            url: url,
            success: function(data) {
                if (data) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    });
                    $('#marcaTr' + id).remove();
                } else {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function adicionarMarca() {
    $('#marcaTrNova').show();
    $('#novaMarca').focus();
}

function novaMarca() {
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false,
        closeOnConfirm: false
    });
    var marca = $('#novaMarca').val();
    if (marca === '') {
        swal('', 'Você precisa preencher a marca', 'warning');
        return false;
    }
    $.post("cadastrar/gravar_marca.php", { nome_marca: marca })
        .done(function(data) {
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                var id = data.id;
                swal({ title: "", text: "Marca adicionada com sucesso", type: "success" });
                $('#marcaTrNova').hide();
                $('#novaMarca').val('');
                var editar = "<button class='btn btn-info btn-sm' id='marcaEditar" + id + "' style='padding:7px;margin:0;' onclick='editarMarca(" + id + ");'><small>Editar</small></button> ";
                var salvar = "<button class='btn btn-success btn-sm' id='marcaSalvar" + id + "' style='padding:7px;margin:0;display:none;' onclick='salvarMarca(" + id + ");'><small>Salvar</small></button> ";
                var excluir = "<button class='btn btn-danger btn-sm' style='padding:7px;margin:0;' onclick='excluirMarca(" + id + ");'><small>Excluir</small></button>";
                var tr = '<tr id="marcaTr' + id + '"><td style="width:50%;"><small id="marcaNome' + id + '">' + marca + '</small></td><td style="width:50%;">' + salvar + editar + excluir + '</td></tr>';
                $('#marcaTrNova').after(tr);
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function editarCategoria(id) {
    var categoria = $('#categoriaNome' + id).html();
    var key = "onkeypress=\"$(this).val(aspas($(this).val()));\" onkeyup=\"$(this).val(aspas($(this).val()));\"";
    $('#categoriaNome' + id).html("<input class=\"form-control input-sm\" " + key + " value=\"" + categoria + "\" id=\"categoriaInput" + id + "\" placehoder=\"Categoria\" style=\"background: white;height: 25px !important;margin: 0;line-height: inherit !important;font-size: 14px;padding: 0;\" />");
    $('#categoriaEditar' + id).hide();
    $('#categoriaSalvar' + id).show();
    $('#categoriaCancelar' + id).show();
}

function salvarCategoria(id) {
    var categoria = $('#categoriaInput' + id).val();
    if (categoria === '') {
        swal({ title: '', text: 'Você precisa preencher a categoria', type: 'warning' });
        return false;
    }
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false
    });
    $.post("alterar/gravar_categoria.php", { codigo_categoria: id, nome_categoria: categoria })
        .done(function(data) {
            var options;
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                swal("", "Categoria alterada com sucesso", "success");
                //ajax
                $('#categoriaNome' + id).html(categoria);
                $('#categoriaEditar' + id).show();
                $('#categoriaSalvar' + id).hide();
                $('#categoriaCancelar' + id).hide();
                $('#categoriaCancelar' + id).removeAttr('onclick');
                $('#categoriaCancelar' + id).attr('onclick', 'cancelarCategoria(' + id + ',\'' + scapeString(categoria) + '\')');
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function excluirCategoria(id) {
    swal({
        title: "Você tem certeza?",
        text: "A categoria será excluida",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        swal({
            title: "",
            text: "Excluindo",
            imageUrl: "assets/img/loader.gif",
            showCancelButton: false,
            showConfirmButton: false
        });
        var url = 'deletar/categoria.php?id=' + id;
        $.ajax({
            url: url,
            success: function(data) {
                if (data) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    });
                    $('#categoriaTr' + id).remove();
                } else {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function adicionarCategoria() {
    $('#categoriaTrNova').show();
    $('#categoriaMarca').focus();
}

function novaCategoria() {
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false,
        closeOnConfirm: false
    });
    var categoria = $('#novaCategoria').val();
    if (categoria === '') {
        swal('', 'Você precisa preencher a categoria', 'warning');
        return false;
    }
    $.post("cadastrar/gravar_categoria.php", { nome_categoria: categoria })
        .done(function(data) {
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                var id = data;
                swal({ title: "", text: "Categoria adicionada com sucesso", type: "success" });
                $('#categoriaTrNova').hide();
                $('#novaCategoria').val('');
                var editar = "<button class='btn btn-info btn-sm' id='categoriaEditar" + id + "' style='padding:7px;margin:0;' onclick='editarCategoria(" + id + ");'><small>Editar</small></button> ";
                var salvar = "<button class='btn btn-success btn-sm' id='categoriaSalvar" + id + "' style='padding:7px;margin:0;display:none;' onclick='salvarCategoria(" + id + ");'><small>Salvar</small></button> ";
                var excluir = "<button class='btn btn-danger btn-sm' style='padding:7px;margin:0;' onclick='excluirCategoria(" + id + ");'><small>Excluir</small></button>";
                var tr = '<tr id="categoriaTr' + id + '"><td style="width:50%;"><small id="categoriaNome' + id + '">' + categoria + '</small></td><td style="width:50%;">' + salvar + editar + excluir + '</td></tr>';
                $('#categoriaTrNova').after(tr);
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function editarSubcategoria(id) {
    var subcategoria = $('#subcategoriaNome' + id).html();
    var key = "onkeypress=\"$(this).val(aspas($(this).val()));\" onkeyup=\"$(this).val(aspas($(this).val()));\"";
    $('#subcategoriaNome' + id).html("<input class=\"form-control input-sm\" " + key + " value=\"" + subcategoria + "\" id=\"subcategoriaInput" + id + "\" placehoder=\"Sub Categoria\" style=\"background: white;height: 25px !important;margin: 0;line-height: inherit !important;font-size: 14px;max-width: 70%;display: inherit;padding: 0;\" />");
    $('#subcategoriaEditar' + id).hide();
    $('#subcategoriaSalvar' + id).show();
    $('#categoriaSub' + id).removeAttr('disabled');
    $('#subcategoriaCancelar' + id).show();
    $('#subcategoriaNovaCategoria' + id).show();
}

function salvarSubcategoria(id) {
    var subcategoria = $('#subcategoriaInput' + id).val();
    var categoria = $('#categoriaSub' + id).val();
    if (subcategoria === '') {
        swal({ title: '', text: 'Você precisa preencher a Sub Categoria', type: 'warning' });
        return false;
    }
    if (categoria === '' || categoria === 0) {
        swal({ title: '', text: 'Você precisa preencher a Categoria', type: 'warning' });
        return false;
    }
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false
    });
    $.post("alterar/gravar_subcategoria.php", { codigo_subcategoria: id, nome_subcategoria: subcategoria, categoria_produto: categoria })
        .done(function(data) {
            var options;

            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                swal("", "Sub Categoria alterada com sucesso", "success");
                //ajax
                $('#subcategoriaNome' + id).html(subcategoria);
                $('#subcategoriaEditar' + id).show();
                $('#subcategoriaSalvar' + id).hide();
                $('#categoriaSub' + id).attr('disabled', 'disabled');
                $('#subcategoriaNovaCategoria' + id).hide();
                $('#subcategoriaCancelar' + id).hide();
                $('#subcategoriaCancelar' + id).removeAttr('onclick');
                $('#subcategoriaCancelar' + id).attr('onclick', 'cancelarSubcategoria(' + id + ',\'' + scapeString(subcategoria) + '\',' + $('#categoriaSub' + id).val() + ')');
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function excluirSubcategoria(id) {
    swal({
        title: "Você tem certeza?",
        text: "A Sub Categoria será excluida",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        swal({
            title: "",
            text: "Excluindo",
            imageUrl: "assets/img/loader.gif",
            showCancelButton: false,
            showConfirmButton: false
        });
        var url = 'deletar/subcategoria.php?id=' + id;
        $.ajax({
            url: url,
            success: function(data) {
                if (data) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    });
                    $('#subcategoriaTr' + id).remove();
                } else {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function adicionarSubcategoria() {
    $('#subcategoriaTrNova').show();
    $('#novaSubcategoria').focus();
}

function novaSubcategoria() {
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false,
        closeOnConfirm: false
    });
    var subcategoria = $('#novaSubcategoria').val();
    var categoria = Number($('#novaCategoriasub').val());
    if (subcategoria === '') {
        swal('', 'Você precisa preencher a Sub Categoria', 'warning');
        return false;
    }
    if (categoria === '' || categoria === 0 || categoria == NaN) {
        swal('', 'Você precisa preencher a Categoria', 'warning');
        return false;
    }
    $.post("cadastrar/gravar_subcategoria.php", { nome_subcategoria: subcategoria, categoria_produto: categoria })
        .done(function(data) {
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                var id = data.id;
                swal({ title: "", text: "Subcategoria adicionada com sucesso", type: "success" });
                var select = $('#categoriaSubSelect').html();
                var select = select.replace('novaCategoriasub', 'categoriaSub' + id);
                var editar = "<button class='btn btn-info btn-sm' id='subcategoriaEditar" + id + "' style='padding:7px;margin:0;' onclick='editarSubcategoria(" + id + ");'><small>Editar</small></button> ";
                var salvar = "<button class='btn btn-success btn-sm' id='subcategoriaSalvar" + id + "' style='padding:7px;margin:0;display:none;' onclick='salvarSubcategoria(" + id + ");'><small>Salvar</small></button> ";
                var excluir = "<button class='btn btn-danger btn-sm' style='padding:7px;margin:0;' onclick='excluirSubcategoria(" + id + ");'><small>Excluir</small></button>";
                var tr = '<tr id="subcategoriaTr' + id + '"><td style="width:50%;"><small id="subcategoriaNome' + id + '">' + subcategoria + '</small>' + select + '</td><td style="width:50%;">' + salvar + editar + excluir + '</td></tr>';
                $('#subcategoriaTrNova').after(tr);
                $('#subcategoriaTrNova').hide();
                $('#novaSubcategoria').val('');
                $('#novaCategoriasub').val(0);
                $('#categoriaSub' + id).val(categoria);
                $('#categoriaSub' + id).attr('disabled', 'disabled');
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function editarUnidadeMedida(id) {
    var unidade_medida = $('#unidade_medidaNome' + id).html();
    var key = "onkeypress=\"$(this).val(aspas($(this).val()));\" onkeyup=\"$(this).val(aspas($(this).val()));\"";
    $('#unidade_medidaNome' + id).html("<input class=\"form-control input-sm\" " + key + " value=\"" + unidade_medida + "\" id=\"unidade_medidaInput" + id + "\" placehoder=\"UnidadeMedida\" style=\"background: white;height: 25px !important;margin: 0;line-height: inherit !important;font-size: 14px;padding: 0;\" />");
    $('#unidade_medidaEditar' + id).hide();
    $('#unidade_medidaSalvar' + id).show();
    $('#unidade_medidaCancelar' + id).show();
}

function salvarUnidadeMedida(id) {
    var unidade_medida = $('#unidade_medidaInput' + id).val();
    if (unidade_medida === '') {
        swal({ title: '', text: 'Você precisa preencher a unidade_medida', type: 'warning' });
        return false;
    }
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false
    });
    $.post("alterar/gravar_unidade_medida.php", { codigo_unidade_medida: id, nome_unidade_medida: unidade_medida })
        .done(function(data) {
            var options;
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                swal("", "Unidade/Medida alterada com sucesso", "success");
                //ajax
                $('#unidade_medidaNome' + id).html(unidade_medida);
                $('#unidade_medidaEditar' + id).show();
                $('#unidade_medidaSalvar' + id).hide();
                $('#unidade_medidaCancelar' + id).hide();
                $('#unidade_medidaCancelar' + id).removeAttr('onclick');
                $('#unidade_medidaCancelar' + id).attr('onclick', 'cancelarUnidadeMedida(' + id + ',\'' + scapeString(unidade_medida) + '\')');
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function excluirUnidadeMedida(id) {
    swal({
        title: "Você tem certeza?",
        text: "A Unidade/Medida será excluida",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        swal({
            title: "",
            text: "Excluindo",
            imageUrl: "assets/img/loader.gif",
            showCancelButton: false,
            showConfirmButton: false
        });
        var url = 'deletar/unidade_medida.php?id=' + id;
        $.ajax({
            url: url,
            success: function(data) {
                if (data) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    });
                    $('#unidade_medidaTr' + id).remove();
                } else {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function adicionarUnidadeMedida() {
    $('#unidade_medidaTrNova').show();
    $('#novaUnidadeMedida').focus();
}

function novaUnidadeMedida() {
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false,
        closeOnConfirm: false
    });
    var unidade_medida = $('#novaUnidadeMedida').val();
    if (unidade_medida === '') {
        swal('', 'Você precisa preencher a Unidade/Medida', 'warning');
        return false;
    }
    $.post("cadastrar/gravar_unidade_medida.php", { nome_unidade_medida: unidade_medida })
        .done(function(data) {
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                var id = data.id;
                swal({ title: "", text: "Unidade/Medida adicionada com sucesso", type: "success" });
                $('#unidade_medidaTrNova').hide();
                $('#novaUnidadeMedida').val('');
                var editar = "<button class='btn btn-info btn-sm' id='unidade_medidaEditar" + id + "' style='padding:7px;margin:0;' onclick='editarUnidadeMedida(" + id + ");'><small>Editar</small></button> ";
                var salvar = "<button class='btn btn-success btn-sm' id='unidade_medidaSalvar" + id + "' style='padding:7px;margin:0;display:none;' onclick='salvarUnidadeMedida(" + id + ");'><small>Salvar</small></button> ";
                var excluir = "<button class='btn btn-danger btn-sm' style='padding:7px;margin:0;' onclick='excluirUnidadeMedida(" + id + ");'><small>Excluir</small></button>";
                var tr = '<tr id="unidade_medidaTr' + id + '"><td style="width:50%;"><small id="unidade_medidaNome' + id + '">' + unidade_medida + '</small></td><td style="width:50%;">' + salvar + editar + excluir + '</td></tr>';
                $('#unidade_medidaTrNova').after(tr);
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function editarFornecedor(id) {
    var fornecedor = $('#fornecedorNome' + id).html();
    var key = "onkeypress=\"$(this).val(aspas($(this).val()));\" onkeyup=\"$(this).val(aspas($(this).val()));\"";
    $('#fornecedorNome' + id).html("<input class=\"form-control input-sm\" " + key + " value=\"" + fornecedor + "\" id=\"fornecedorInput" + id + "\" placehoder=\"Fornecedor\" style=\"background: white;height: 25px !important;margin: 0;line-height: inherit !important;font-size: 14px;padding: 0;\" />");
    $('#fornecedorEditar' + id).hide();
    $('#fornecedorSalvar' + id).show();
    $('#fornecedorCancelar' + id).show();
}

function salvarFornecedor(id) {
    var fornecedor = $('#fornecedorInput' + id).val();
    if (fornecedor === '') {
        swal({ title: '', text: 'Você precisa preencher o fornecedor', type: 'warning' });
        return false;
    }
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false
    });
    $.post("alterar/gravar_fornecedor.php", { codigo_fornecedor: id, nome_fornecedor: fornecedor })
        .done(function(data) {
            var options;
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                swal("", "Fornecedor alterado com sucesso", "success");
                //ajax
                $('#fornecedorNome' + id).html(fornecedor);
                $('#fornecedorEditar' + id).show();
                $('#fornecedorSalvar' + id).hide();
                $('#fornecedorCancelar' + id).hide();
                $('#fornecedorCancelar' + id).removeAttr('onclick');
                $('#fornecedorCancelar' + id).attr('onclick', 'cancelarFornecedor(' + id + ',\'' + scapeString(fornecedor) + '\')');
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function excluirFornecedor(id) {
    swal({
        title: "Você tem certeza?",
        text: "O fornecedor será excluido",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        swal({
            title: "",
            text: "Excluindo",
            imageUrl: "assets/img/loader.gif",
            showCancelButton: false,
            showConfirmButton: false
        });
        var url = 'deletar/fornecedor.php?id=' + id;
        $.ajax({
            url: url,
            success: function(data) {
                if (data) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    });
                    $('#fornecedorTr' + id).remove();
                } else {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function adicionarFornecedor() {
    $('#fornecedorTrNova').show();
    $('#novaFornecedor').focus();
}

function novaFornecedor() {
    swal({
        title: "",
        text: "Salvando",
        imageUrl: "assets/img/loader.gif",
        showCancelButton: false,
        showConfirmButton: false,
        closeOnConfirm: false
    });
    var fornecedor = $('#novaFornecedor').val();
    if (fornecedor === '') {
        swal('', 'Você precisa preencher o fornecedor', 'warning');
        return false;
    }
    $.post("cadastrar/gravar_fornecedor.php", { nome_fornecedor: fornecedor })
        .done(function(data) {
            if (erroJSON(data.codigo) === 0) {
                $('.alert-no-result').hide();
                var id = data.id;
                swal({ title: "", text: "Fornecedor adicionado com sucesso", type: "success" });
                $('#fornecedorTrNova').hide();
                $('#novaFornecedor').val('');
                var editar = "<button class='btn btn-info btn-sm' id='fornecedorEditar" + id + "' style='padding:7px;margin:0;' onclick='editarFornecedor(" + id + ");'><small>Editar</small></button> ";
                var salvar = "<button class='btn btn-success btn-sm' id='fornecedorSalvar" + id + "' style='padding:7px;margin:0;display:none;' onclick='salvarFornecedor(" + id + ");'><small>Salvar</small></button> ";
                var excluir = "<button class='btn btn-danger btn-sm' style='padding:7px;margin:0;' onclick='excluirFornecedor(" + id + ");'><small>Excluir</small></button>";
                var tr = '<tr id="fornecedorTr' + id + '"><td style="width:50%;"><small id="fornecedorNome' + id + '">' + fornecedor + '</small></td><td style="width:50%;">' + salvar + editar + excluir + '</td></tr>';
                $('#fornecedorTrNova').after(tr);
            } else {

                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            }
        })
        .fail(function() {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        });
}

function cancelarMarca(id, nome) {
    if (id === null || id === undefined || id === '') {
        var id = 0;
    }
    if (id > 0) {
        $('#marcaNome' + id).html(nome);
        $('#marcaSalvar' + id).hide();
        $('#marcaCancelar' + id).hide();
        $('#marcaEditar' + id).show();
        //window.location.reload();
    } else {
        $('#novaMarca').val('');
        $('#marcaTrNova').hide();
    }
}

function cancelarCategoria(id, nome) {
    if (id === null || id === undefined || id === '') {
        var id = 0;
    }
    if (id > 0) {
        $('#categoriaSalvar' + id).hide();
        $('#categoriaCancelar' + id).hide();
        $('#categoriaEditar' + id).show();
        $('#categoriaNome' + id).html(nome);
        //window.location.reload();
    } else {
        $('#novaCategoria').val('');
        $('#categoriaTrNova').hide();
    }
}

function cancelarSubcategoria(id, nome, categoria) {
    if (id === null || id === undefined || id === '') {
        var id = 0;
    }
    if (id > 0) {
        $('#subcategoriaSalvar' + id).hide();
        $('#subcategoriaCancelar' + id).hide();
        $('#subcategoriaEditar' + id).show();
        $('#subcategoriaNome' + id).html(nome);
        $('#categoriaSub' + id).val(categoria);
        $('#categoriaSub' + id).attr('disabled', 'disabled');
        $('#subcategoriaNovaCategoria' + id).hide();
        //window.location.reload();
    } else {
        $('#novaCategoriasub').val('');
        $('#novaSubategoria').val('');
        $('#subcategoriaTrNova').hide();
    }
}

function cancelarUnidadeMedida(id, nome) {
    if (id === null || id === undefined || id === '') {
        var id = 0;
    }
    if (id > 0) {
        $('#unidade_medidaSalvar' + id).hide();
        $('#unidade_medidaCancelar' + id).hide();
        $('#unidade_medidaEditar' + id).show();
        $('#unidade_medidaNome' + id).html(nome);
        //window.location.reload();
    } else {
        $('#novaUnidadeMedida').val('');
        $('#unidade_medidaTrNova').hide();
    }
}

function cancelarFornecedor(id, nome) {
    if (id === null || id === undefined || id === '') {
        var id = 0;
    }
    if (id > 0) {
        $('#fornecedorSalvar' + id).hide();
        $('#fornecedorCancelar' + id).hide();
        $('#fornecedorEditar' + id).show();
        $('#fornecedorNome' + id).html(nome);
        //window.location.reload();
    } else {
        $('#novaFornecedor').val('');
        $('#fornecedorTrNova').hide();
    }
}

function logout() {
    swal({
        title: "",
        text: "Você tem certeza que deseja sair?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        location.href = 'deslogar.php';
    });
}

function limparPesquisa() {
    $('#inputPesquisa').val('');
    $('#limparPesquisa').fadeOut();
}

function FormPesquisa() {
    var text = $('#inputPesquisa').val();
    if (!text) {
        $('#inputPesquisa').attr('disabled', 'disabled');
    }
    return true;
}

function gravarProduto() {
    var nome_produto = $('input[name=nome_produto]').val();
    var quantidade_produto = $('input[name=quantidade_produto]').val();
    var validade_produto = $('input[name=validade_produto]').val();
    if (nome_produto === '') {
        swal('', 'Você precisa preencher um nome para o produto', 'warning');
        return false;
    } else if (quantidade_produto === '') {
        swal('', 'Você precisa preencher a quantidade do produto', 'warning');
        return false;
    } else if (validade_produto === '') {
        swal('', 'Você precisa indicar a data de validade do produto', 'warning');
        return false;
    } else {
        genericsubmit('gravarProduto', 'Produto', false);
        return true;
    }
}

function maskIt(w, e, m, r, a) {
    // Cancela se o evento for Backspace
    if (!e) var e = window.event
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    // Variáveis da função
    var txt = (!r) ? w.value.replace(/[^\d]+/gi, '') : w.value.replace(/[^\d]+/gi, '').reverse();
    var mask = (!r) ? m : m.reverse();
    var pre = (a) ? a.pre : "";
    var pos = (a) ? a.pos : "";
    var ret = "";
    if (code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g, '').length) return false;
    // Loop na máscara para aplicar os caracteres
    for (var x = 0, y = 0, z = mask.length; x < z && y < txt.length;) {
        if (mask.charAt(x) != '#') {
            ret += mask.charAt(x);
            x++;
        } else {
            ret += txt.charAt(y);
            y++;
            x++;
        }
    }
    // Retorno da função
    ret = (!r) ? ret : ret.reverse()
    w.value = pre + ret + pos;
}
// Novo método para o objeto 'String'
String.prototype.reverse = function() {
    return this.split('').reverse().join('');
};

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = number,
        c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep,
        s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function calcula(operacion) {
    var operando1 = parseFloat(document.calc.operando1.value.replace(/\./g, "").replace(",", "."));
    var operando2 = parseFloat(document.calc.operando2.value.replace(/\./g, "").replace(",", "."));
    var result = eval(operando1 + operacion + operando2);
    document.calc.resultado.value = number_format(result, 2, ',', '.');
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function getAllUrlParams(url) {

    // get query string from url (optional) or window
    var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

    // we'll store the parameters here
    var obj = {};

    // if query string exists
    if (queryString) {

        // stuff after # is not part of query string, so get rid of it
        queryString = queryString.split('#')[0];

        // split our query string into its component parts
        var arr = queryString.split('&');

        for (var i = 0; i < arr.length; i++) {
            // separate the keys and the values
            var a = arr[i].split('=');

            // in case params look like: list[]=thing1&list[]=thing2
            var paramNum = undefined;
            var paramName = a[0].replace(/\[\d*\]/, function(v) {
                paramNum = v.slice(1, -1);
                return '';
            });

            // set parameter value (use 'true' if empty)
            var paramValue = typeof(a[1]) === 'undefined' ? true : a[1];

            // (optional) keep case consistent
            paramName = paramName.toLowerCase();
            paramValue = paramValue.toLowerCase();

            // if parameter name already exists
            if (obj[paramName]) {
                // convert value to array (if still string)
                if (typeof obj[paramName] === 'string') {
                    obj[paramName] = [obj[paramName]];
                }
                // if no array index number specified...
                if (typeof paramNum === 'undefined') {
                    // put the value on the end of the array
                    obj[paramName].push(paramValue);
                }
                // if array index number specified...
                else {
                    // put the value at that index number
                    obj[paramName][paramNum] = paramValue;
                }
            }
            // if param name doesn't exist yet, set it
            else {
                obj[paramName] = paramValue;
            }
        }
    }

    return obj;
}

function scapeString(str) {
    return str.replace(/'/g, "\\'");
}

function aspas(str) {
    var str = str.replace(/'/g, "");
    var str = str.replace(/"/g, "");
    return str;
}

function origemJSON(str) {
    return Number(str.split('.')[0]);
}

function funcaoJSON(str) {
    return Number(str.match(/\.([^)]+)\./)[1]);
}

function erroJSON(str) {
    try {
        return Number(str.split('.')[2]);
    } catch (e) {}
}

function mensagemErro(erro) {
    switch (erro) {
        //Produto
        case '1.1.1':
            return 'Não foi possível salvar o produto.<br />Tente novamente.';
            break;
        case '1.2.1':
            return 'Não foi possível atualizar os dados do produto.<br />Tente novamente.';
            break;
        case '1.3.1':
            return 'Não foi possível excluír o produto.<br />Tente novamente.';
            break;
        case '1.4.1':
            return 'Não foi possível obter os produtos.<br />Tente novamente.';
            break;
        case '1.4.2':
            return 'Não foi possível obter o produto.<br />Tente novamente.';
            break;
        case '1.4.3':
            return 'Não foi possível obter o produto.<br />Tente novamente.';
            break;
        case '1.4.4':
            return 'Não foi possível obter os produtos.<br />Tente novamente.';
            break;
        case '1.4.5':
            return 'Não foi possível obter o produto.<br />Tente novamente.';
            break;  
        case '1.4.6':
            return 'Não foi possível obter o produto.<br />Tente novamente.';
            break;
        case '1.4.7':
            return 'Não foi possível obter o gráfico.<br />Tente novamente.';
            break;                           
            //Marca
        case '2.1.1':
            return 'Não foi possível salvar a marca.<br />Tente novamente.';
            break;
        case '2.1.2':
            return 'Esta marca já existe!';
            break;
        case '2.2.1':
            return 'Não foi possível atualizar a marca.<br />Tente novamente.';
            break;
        case '2.2.2':
            return 'Esta marca já existe!';
            break;    
        case '2.3.1':
            return 'Não foi possível excluír a marca.<br />Tente novamente.';
            break;
        case '2.3.2':
            return 'Não foi possível excluír a marca.<br />Tente novamente.';
            break;
        case '2.4.1':
            return 'Não foi possível obter as marcas.<br />Tente novamente.';
            break;
        case '2.4.2':
            return 'Não foi possível obter a marca.<br />Tente novamente.';
            break;
        case '2.4.3':
            return 'Não foi possível obter a marca.<br />Tente novamente.';
            break;
        case '2.4.4':
            return 'Não foi possível obter as marcas.<br />Tente novamente.';
            break;                
            //Categoria
        case '3.1.1':
            return 'Não foi possível salvar a categoria.<br />Tente novamente.';
            break;
        case '3.1.2':
            return 'Esta categoria já existe!';
            break;
        case '3.2.1':
            return 'Não foi possível atualizar a categoria.<br />Tente novamente.';
            break;
        case '3.2.2':
            return 'Esta categoria já existe!';
            break;   
        case '3.3.1':
            return 'Não foi possível excluír a categoria.<br />Tente novamente.';
            break;
        case '3.3.2':
            return 'Não foi possível excluír a categoria.<br />Tente novamente.';
            break;
        case '3.4.1':
            return 'Não foi possível obter as categorias.<br />Tente novamente.';
            break;
        case '3.4.2':
            return 'Não foi possível obter a categoria.<br />Tente novamente.';
            break;
        case '3.4.3':
            return 'Não foi possível obter a categoria.<br />Tente novamente.';
            break;
        case '3.4.4':
            return 'Não foi possível obter as categorias.<br />Tente novamente.';
            break;                 
            //Subategoria
        case '4.1.1':
            return 'Não foi possível salvar a categoria.<br />Tente novamente.';
            break;
        case '4.1.2':
            return 'Esta Subcategoria já existe!';
            break;
        case '4.2.1':
            return 'Não foi possível atualizar a subcategoria.<br />Tente novamente.';
            break;
        case '4.2.2':
            return 'Esta Subcategoria já existe!';
            break;    
        case '4.3.1':
            return 'Não foi possível excluír a subcategoria.<br />Tente novamente.';
            break;
        case '4.3.2':
            return 'Não foi possível excluír a subcategoria.<br />Tente novamente.';
            break;
        case '4.4.1':
            return 'Não foi possível obter as subcategorias.<br />Tente novamente.';
            break;
        case '4.4.2':
            return 'Não foi possível obter a subcategoria.<br />Tente novamente.';
            break;
        case '4.4.3':
            return 'Não foi possível obter a subcategoria.<br />Tente novamente.';
            break;
        case '4.4.4':
            return 'Não foi possível obter as subcategorias.<br />Tente novamente.';
            break;
        case '4.4.5':
            return 'Não foi possível obter as subcategorias.<br />Tente novamente.';
            break;               
            //Unidade Medida
        case '5.1.1':
            return 'Não foi possível salvar a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.1.2':
            return 'Esta Unidade/Medida já existe!';
            break;
        case '5.2.1':
            return 'Não foi possível atualizar a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.2.2':
            return 'Esta Unidade/Medida já existe!';
            break;    
        case '5.3.1':
            return 'Não foi possível excluír a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.3.2':
            return 'Não foi possível excluír a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.4.1':
            return 'Não foi possível obter a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.4.2':
            return 'Não foi possível obter a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.4.3':
            return 'Não foi possível obter a Unidade/Medida.<br />Tente novamente.';
            break;
        case '5.4.4':
            return 'Não foi possível obter a Unidade/Medida.<br />Tente novamente.';
            break;               
            //Fornecedor
        case '6.1.1':
            return 'Não foi possível salvar o fornecedor.<br />Tente novamente.';
            break;
        case '6.1.2':
            return 'Este fornecedor já existe!';
            break;
        case '6.2.1':
            return 'Não foi possível atualizar o fornecedor.<br />Tente novamente.';
            break;
        case '6.2.2':
            return 'Este fornecedor já existe!';
            break;   
        case '6.3.1':
            return 'Não foi possível excluír o fornecedor.<br />Tente novamente.';
            break;
        case '6.3.2':
            return 'Não foi possível excluír o fornecedor.<br />Tente novamente.';
            break;
        case '6.4.1':
            return 'Não foi possível obter os fornecedores.<br />Tente novamente.';
            break;
        case '6.4.2':
            return 'Não foi possível obter o fornecedor.<br />Tente novamente.';
            break;
        case '6.4.3':
            return 'Não foi possível obter o fornecedor.<br />Tente novamente.';
            break;
        case '6.4.4':
            return 'Não foi possível obter os fornecedores.<br />Tente novamente.';
            break;
        	//Usuario
        case '7.1.1':
            return 'Não foi possível cadastrar o usuário.<br />Tente novamente.';
            break;
        case '7.1.2':
            return 'Este usuário já existe!';
            break;
        case '7.2.1':
            return 'Não foi possível atualizar o usuário.<br />Tente novamente.';
            break; 
        case '7.2.2':
            return 'Este usuário já existe!';
            break; 
        case '7.3.1':
            return 'Não foi possível excluír o usuário.<br />Tente novamente.';
            break;  
        case '7.4.1':
            return 'Usuário incorreto.<br />Tente novamente.';
            break;
        case '7.4.2':
            return 'Usuário incorreto.<br />Tente novamente.';
            break;
            //Usuario Cadastro
        case '8.1.1':
            return 'Não foi possível cadastrar o usuário.<br />Tente novamente.';
            break;
        case '8.2.1':
            return 'Não foi possível atualizar o usuário.<br />Tente novamente.';
            break;
        case '8.3.1':
            return 'Não foi possível excluír o usuário.<br />Tente novamente.';
            break; 
        case '8.4.1':
            return 'Não foi possível obter o usuário.<br />Tente novamente.';
            break; 
            //Usuario Configuracao 
        case '9.1.1':
            return 'Não foi possível cadastrar as configurações de usuário.<br />Tente novamente.';
            break;
        case '9.2.1':
            return 'Não foi possível atualizar as configurações de usuário.<br />Tente novamente.';
            break; 
        case '9.3.1':
            return 'Não foi possível excluír as configurações de usuário.<br />Tente novamente.';
            break;
        case '9.4.1':
            return 'Não foi possível obter as configurações de usuário.<br />Tente novamente.';
            break;
            //Usuario Email
        case '10.1.1':
            return 'Não foi possível salvar o e-mail.<br />Tente novamente.';
            break;
        case '10.1.2':
            return 'Este e-mail já existe!';
            break;
        case '10.2.1':
            return 'Não foi possível atualizar o e-mail.<br />Tente novamente.';
            break;
        case '10.2.2':
            return 'Este e-mail já existe!';
            break;    
        case '10.3.1':
            return 'Não foi possível excluír o e-mail.<br />Tente novamente.';
            break;      
         case '10.4.1':
            return 'Não foi possível obter os e-mails.<br />Tente novamente.';
            break;                                    
         	//Usuario Telefone
        case '11.1.1':
            return 'Não foi possível salvar o telefone.<br />Tente novamente.';
            break;
        case '11.1.2':
            return 'Este telefone já existe!';
            break;
        case '11.2.1':
            return 'Não foi possível atualizar o telefone.<br />Tente novamente.';
            break;
        case '11.2.2':
            return 'Este telefone já existe!';
            break;    
        case '11.3.1':
            return 'Não foi possível excluír o telefone.<br />Tente novamente.';
            break;      
        case '11.4.1':
            return 'Não foi possível obter os telefones.<br />Tente novamente.';
            break;          
            //Aviso Produto
        case '13.1.1':
            return 'Não foi possível cadastrar o aviso de validade.<br />Tente novamente.';
            break;
        case '13.2.1':
            return 'Não foi possível atualizar o aviso de validade.<br />Tente novamente.';
            break;    
        case '13.4.1':
            return 'Não foi possível obter a configuração do aviso de validade.<br />Tente novamente.';
            break;
            //Relatorio
        case '14.4.1':
            return 'Não foi possível obter o relatório.<br />Tente novamente.';
            break;
            //Aviso Historico
        case '18.3.1':
            return 'Não foi possível excluír o relatório.<br />Tente novamente.';
            break;
        case '18.3.2':
            return 'Não foi possível excluír os relatórios.<br />Tente novamente.';
            break;
        case '18.4.1':
            return 'Não foi possível obter os relatórios.<br />Tente novamente.';
            break; 
        case '18.4.2':
            return 'Não foi possível obter o relatório.<br />Tente novamente.';
            break;         
        case '18.4.3':
            return 'Não foi possível obter o relatório.<br />Tente novamente.';
            break;
        case '18.4.4':
            return 'Não foi possível obter os relatórios.<br />Tente novamente.';
            break;
        case '18.4.5':
            return 'Não foi possível obter o relatório.<br />Tente novamente.';
            break;
        case '18.4.6':
            return 'Não foi possível obter os relatórios.<br />Tente novamente.';
            break; 
        	//Campo Relatorio Configuracao    
        case '20.1.1':
            return 'Não foi possível salvar (Personalizar Campos do Relatório).<br />Tente novamente.';
            break;
        case '20.2.1':
            return 'Não foi possível alterar (Personalizar Campos do Relatório).<br />Tente novamente.';
            break;  
        case '20.4.1':
            return 'Não foi possível obter os campos do relatório.<br />Tente novamente.';
            break;  
            //Aviso Periodico  
        case '21.1.1':
            return 'Não foi possível cadastrar o aviso relatório periódico.<br />Tente novamente.';
            break;
        case '21.2.1':
            return 'Não foi possível atualizar o aviso relatório periódico.<br />Tente novamente.';
            break;    
        case '21.4.1':
            return 'Não foi possível obter o aviso relatório periódico.<br />Tente novamente.';
            break;
            //Meus Dados (menu)
        case '17.4.1':
            return 'Não foi possível obter o usuário.<br />Tente novamente.';
            break;        	               
        default:
            return 'Ocorreu um erro desconhecido';
            break;    
    }
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}


function logarFacebook() {
    FB.getLoginStatus(function(response) {
        tratarFacebook(response);
    });
}

function tratarFacebook(response) {
    if (response.status === 'connected') {
        salvarFacebook();
    } else {
        swal('', 'Você precisa autorizar o acesso no Facebook', 'warning');
    }
}

function salvarFacebook() {
    FB.api('/me', function(response) {
        $('.modal').modal('hide');
        console.log(JSON.stringify(response));
        swal({
            title: "Aguarde",
            text: "Estamos obtendo os seus dados",
            imageUrl: "app/assets/img/loader.gif",
            showConfirmButton: false
        });
        setTimeout(function() { swal.close(); }, 2000);
        //response.name
    });
}

function logarGoogle(googleUser = '') {
    var profile = googleUser.getBasicProfile();
    /*console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.*/
    salvarGoogle(profile);
    setTimeout(function() { swal.close(); }, 2000);
}

function salvarGoogle(profile) {
    $('.modal').modal('hide');
    console.log(JSON.stringify(googleUser));
    /*swal({
        title: "Aguarde",
        text: "Estamos obtendo os seus dados",
        imageUrl: "app/assets/img/loader.gif",
        showConfirmButton: false
    });*/
}

$(function() {
    $.contextMenu({
        selector: '.context-menu-one',
        callback: function(key, options) {
            var m = "clicked: " + key;
            //window.console && console.log(m) || alert(m); 
        },
        items: {
            copy: { name: "Copiar" },
            "quit": { name: "Fechar" }
        }
    });

    $('.context-menu-one').on('click', function(e) {
        console.log('clicked', this);
    })
});

function alterar_senha() {
    var atual = $('#atual').val();
    var nova = $('#nova').val();
    var confirmacao = $('#confirmacao').val();
    if (atual == '') $('#nivel_senha').html('<small class="red-text">Você precisa preencher a senha atual</small>');
    else if (nova.length < 6 || nova.length > 18) $('#nivel_senha').html('<small class="red-text">A senha deve ter entre 6 e 18 digitos</small>');
    else if (nova != confirmacao) $('#nivel_senha').html('<small class="red-text">Nova senha e a confirmação são diferentes</small>');
    else {
        swal({
            title: "<center>Aguarde</center>",
            html: true,
            imageUrl: "assets/img/loader.gif",
            showConfirmButton: false
        });
        var url = "alterar/gravar_usuario.php";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                atual: atual,
                nova: nova,
                parametro: 1
            },
            success: function(data) {
                if (erroJSON(data.codigo) === 0) {
                    swal({
                            title: "Alterado com sucesso",
                            text: "Acesse novamente",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "OK",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function() {
                            setTimeout(function() { location.href = 'deslogar.php'; }, 500);
                        });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    }
}

function alterar_dados() {
    var email = $('#email_acesso').val();
    var senha = $('#senha_dados_input').val();
    if (!validaEmail(email)) swal('', 'Digite um email válido!', 'warning');
    else {
        $('#email_dados').hide();
        $('#senha_dados').show();
        $('#senha_dados_input').focus();
        if (senha == '') swal('', 'Digite sua senha!', 'warning');
        else {
            swal({
                title: "<center>Aguarde</center>",
                html: true,
                imageUrl: "assets/img/loader.gif",
                showConfirmButton: false
            });
            var url = "alterar/gravar_usuario.php";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    usuario: email,
                    atual: senha,
                    parametro: 2
                },
                success: function(data, status) {
                    if (erroJSON(data.codigo) === 0) {
                        swal({
                                title: "Alterado com sucesso",
                                text: "Acesse novamente",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function() {
                                setTimeout(function() { location.href = 'deslogar.php'; }, 500);
                            });
                    } else {
                        swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                    }
                },
                error: function(data, status) {
                    swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
                }
            });
        }
    }
}

$(function() {
    $("#nova").complexify({}, function(valid, complexity) {
        if ($("#nova").val() != '') {
            if (complexity < 20) $('#nivel_senha').html('<small class="red-text">Senha Muito Fraca</small>');
            if (complexity > 20 && complexity < 30) $('#nivel_senha').html('<small class="orange-text">Senha Regular</small>');
            if (complexity > 30 && complexity < 40) $('#nivel_senha').html('<small class="cyan-text">Senha Boa</small>');
            if (complexity > 40) $('#nivel_senha').html('<small class="green-text">Senha Muito Boa</small>');
        }
    });
    $("#nova").keyup(function() {
        if ($("#nova").val() != '') {
            $("#confirmacao").val('');
            $("#confirmacao").removeAttr('disabled');
        } else {
            $("#confirmacao").val('');
            $("#confirmacao").attr('disabled', 'disabled');
        }
    });
    $("#nova").blur(function() {
        if ($("#nova").val() == '') {
            $("#confirmacao").val('');
            $("#confirmacao").attr('disabled', 'disabled');
            $('#nivel_senha').html('');
        }
    });
    $("#confirmacao").blur(function() {
        if ($("#confirmacao").val() == '') {
            $('#nivel_senha').html('');
        }
    });
});

function maskIt(w, e, m, r, a) {
    // Cancela se o evento for Backspace
    if (!e) var e = window.event
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    // Variáveis da função
    var txt = (!r) ? w.value.replace(/[^\d]+/gi, '') : w.value.replace(/[^\d]+/gi, '').reverse();
    var mask = (!r) ? m : m.reverse();
    var pre = (a) ? a.pre : "";
    var pos = (a) ? a.pos : "";
    var ret = "";
    if (code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g, '').length) return false;
    // Loop na máscara para aplicar os caracteres
    for (var x = 0, y = 0, z = mask.length; x < z && y < txt.length;) {
        if (mask.charAt(x) != '#') {
            ret += mask.charAt(x);
            x++;
        } else {
            ret += txt.charAt(y);
            y++;
            x++;
        }
    }
    // Retorno da função
    ret = (!r) ? ret : ret.reverse()
    w.value = pre + ret + pos;
}

String.prototype.reverse = function() {
    return this.split('').reverse().join('');
};

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = number,
        c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep,
        s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function calcula(operacion) {
    var operando1 = parseFloat(document.calc.operando1.value.replace(/\./g, "").replace(",", "."));
    var operando2 = parseFloat(document.calc.operando2.value.replace(/\./g, "").replace(",", "."));
    var result = eval(operando1 + operacion + operando2);
    document.calc.resultado.value = number_format(result, 2, ',', '.');
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function validaEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function realizar_cadastro() {
    var nome = $('#nome').val();
    var email = $('#email').val();
    var senha = $('#nova').val();
    var confirmacao = $('#confirmacao').val();
    if (nome.length < 2) swal('', 'Você precisa preencher o nome', 'warning');
    else if (nome.length < 2) swal('', 'Digite um nome válido', 'warning');
    else if (email == '') swal('', 'Você precisa preencher o email', 'warning');
    else if (!validaEmail(email)) swal('', 'Digite um email válido', 'warning');
    else if (senha == '') swal('', 'Você precisa digitar uma senha', 'warning');
    else if (senha.length < 6 || senha.length > 18) swal('', 'A senha deve ter entre 6 e 18 digitos', 'warning');
    else if (confirmacao == '') swal('', 'Você precisa digitar a confirmação da senha', 'warning');
    else if (senha != confirmacao) swal('', 'A senha e a confirmação são diferentes', 'error');
    else {
        return swal('', 'Cadastro Indisponível no momento', 'warning');
        swal({
            title: "<center>Aguarde</center>",
            html: true,
            imageUrl: "app/assets/img/loader.gif",
            showConfirmButton: false
        });
        var url = "app/cadastrar/gravar_perfil.php";
        $.ajax({
            url: url,
            type: 'POST',
            data: { nome: nome, senha: senha, email: email },
            success: function(data) {
                if (erroJSON(data.codigo) === 0) {
                    $('.alert-no-result').hide();
                    swal({
                            title: "",
                            text: "Cadastro realizado com successo",
                            type: "success",
                            confirmButtonText: "OK",
                            html: true,
                            closeOnConfirm: false
                        },
                        function() {
                            $('#modalRegister input').val('');
                            $('#nivel_senha').html('');
                            swal.close();
                            $('#modalRegister').modal('hide');
                            $('#modalLogin').modal('show');
                            $('#usuario').val(email);
                        });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    }
}

function removerEmail(id) {
    $('#email-row' + id).remove();
}

function removerCelular(id) {
    $('#celular-row' + id).remove();
}

function insereEmail(v = true) {
    var total = $('.email-row').length;
    var email = ($('#novo_email').val()).toLowerCase().replace(/ /g, '');
    var withValue = existeEmail(email);
    if (email == '') { if (v == true) { swal('', 'Você precisa digitar um email', 'warning'); } return true; } else if (withValue > 0) { swal('', 'Já existe esse e-mail na lista', 'warning'); return false; } else if (!validaEmail(email)) { swal('', 'Digite um email válido', 'warning'); return false; } else if (total > 4) { swal('', 'Você só pode cadastrar até 5 emails', 'warning'); return false; } else {
        $('#emails').append('<tr class="email-row" id="email-row' + total + '"><input type="hidden" name="emails' + total + '" class="input-emails" value="' + email + '" /><td>' + email + '</td><td align="right"><button type="button" class="btn btn-sm btn-danger" style="padding: 5px 10px 5px 10px;margin: 0;" onclick="removerEmail(' + total + ');"><i class="fa ion-trash-b"></i></button></td></tr>');
        $('#novo_email').val('');
        return true;
    }
}

function existeEmail(email) {
    var result = 0;
    $(".input-emails").each(function() {
        var input = ($(this).val()).toLowerCase().replace(/ /g, '');
        if (input == email.toLowerCase().replace(/ /g, '')) { result += 1; }
    });
    return result;
}

function insereCelular(v = true) {
    var total = $('.celular-row').length;
    var celular = ($('#novo_celular').val()).toLowerCase().replace(/ /g, '');
    var withValue = existeCelular(celular);
    if (celular == '') { if (v == true) { swal('', 'Você precisa digitar um celular', 'warning'); } return true; } else if (withValue > 0) { swal('', 'Já existe esse celular na lista', 'warning'); return false } else if ((celular.replace(/\D/g, '')).length < 11) { swal('', 'Digite um celular válido', 'warning'); return false } else if (total > 4) { swal('', 'Você só pode cadastrar até 5 celulares', 'warning'); return false; } else {
        $('#celulares').append('<tr class="celular-row" id="celular-row' + total + '"><input type="hidden" name="celulares' + total + '" id="celulares' + total + '" class="input-celulares" value="' + (celular.replace(/\D/g, '')) + '" /><td>' + celular + '</td><td align="right"><button type="button" class="btn btn-sm btn-danger" style="padding: 5px 10px 5px 10px;margin: 0;" onclick="removerCelular(' + total + ');"><i class="fa ion-trash-b"></i></button></td></tr>');
        $('#novo_celular').val('');
        return true;
    }
}

function existeCelular(celular) {
    var result = 0;
    $(".input-celulares").each(function() {
        var input = ($(this).val()).replace(/\D/g, '').toLowerCase().replace(/ /g, '');
        if (input == celular.replace(/\D/g, '').toLowerCase().replace(/ /g, '')) { result += 1; }
    });
    return result;
}

function salvarDados() {
    var nome = $('#nome').val();
    var documento = ($('#documento').val()).replace(/\D/g, '');
    var email = ($('#email').val()).toLowerCase().replace(/ /g, '');
    var cep = ($('#cep').val()).replace(/\D/g, '');
    var endereco = $('#endereco').val();
    var numero = $('#numero').val();
    var complemento = $('#complemento').val();
    var bairro = $('#bairro').val();
    var cidade = $('#cidade').val();
    var estado = $('#estado').val();
    var telefone = ($('#telefone').val()).replace(/\D/g, '');
    var celular = ($('#celular').val()).replace(/\D/g, '');
    if (nome == '') swal('', 'Você precisa preencher o nome', 'warning');
    else if (documento.length < 11 || documento.length > 14) swal('', 'Documento inválido', 'warning');
    else if (validarCNPJ(documento) == false && documento.length == 14) swal('', 'Documento inválido', 'warning');
    else if (validarCPF(documento) == false && documento.length == 11) swal('', 'Documento inválido', 'warning');
    else if (email == '') swal('', 'Você precisa preencher o email', 'warning');
    else if (validaEmail(email) == false) swal('', 'Email inválido', 'warning');
    else if (cep.length < 8) swal('', 'CEP inválido', 'warning');
    else if (endereco == '') swal('', 'Você precisa preencher o endereço', 'warning');
    else if (numero == '') swal('', 'Você precisa preencher o número', 'warning');
    else if (bairro == '') swal('', 'Você precisa preencher o bairro', 'warning');
    else if (cidade == '') swal('', 'Você precisa preencher a cidade', 'warning');
    else if (estado == '') swal('', 'Você precisa escolher o estado', 'warning');
    else if (estado == 'Selecione') swal('', 'Você precisa escolher o estado', 'warning');
    else if (estado == '...') swal('', 'Você precisa escolher o estado', 'warning');
    else if (telefone.length < 10) swal('', 'Celular inválido', 'warning');
    else if (celular.length < 11) swal('', 'Celular inválido', 'warning');
    else {
        swal({
            title: "<center>Aguarde</center>",
            html: true,
            imageUrl: "assets/img/loader.gif",
            showConfirmButton: false
        });
        var url = "alterar/gravar_usuario_cadastro.php";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                nome: nome,
                documento: documento,
                email: email,
                cep: cep,
                endereco: endereco,
                complemento: complemento,
                numero: numero,
                bairro: bairro,
                cidade: cidade,
                estado: estado,
                telefone: telefone,
                celular: celular
            },
            success: function(data) {
                if (erroJSON(data.codigo) === 0) {
                    swal({ title: "", text: "Cadastro alterado com successo", type: "success" });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    }
}

function validarCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

}

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito 
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito 
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function minmax(value, min, max) {
    if (parseInt(value) < min || isNaN(parseInt(value)))
        return 1;
    else if (parseInt(value) > max)
        return max;
    else return value;
}


function alterar_aviso() {
    var aviso_periodo = Number($('#aviso_periodo').val());
    var aviso_validade = Number($('#aviso_validade').val());
    var aviso_vencido = Number($('#aviso_vencido').val());
    var relatorio_alerta = Number($('#relatorio_alerta').val());
    var validade_alerta = Number($('#validade_alerta').val());
    var vencido_alerta = Number($('#vencido_alerta').val());
    var emails = insereEmail(false);
    var celulares = insereCelular(false);
    if (aviso_periodo == '') swal("", "Você precisa indicar o envio do relatório!", "warning");
    else if (aviso_periodo == '') swal("", "Você precisa indicar o alerta de validade próxima!", "warning");
    else if (emails == false) return false;
    else if (celulares == false) return false;
    else if (relatorio_alerta == 1 && aviso_periodo > 30)
        swal("", "Número de dias excedido para o envio de relatório. (Máximo 30 dias)", "warning");
    else if (relatorio_alerta == 2 && aviso_periodo > 12)
        swal("", "Número de meses excedido para o envio de relatório. (Máximo 12 meses)", "warning");
    else if (relatorio_alerta == 3 && aviso_periodo > 2)
        swal("", "Número de anos excedido para o envio de relatório. (Máximo 2 anos)", "warning");
    else if (validade_alerta == 1 && aviso_validade > 30)
        swal("", "Número de dias excedido para a alerta de validade próxima. (Máximo 30 dias)", "warning");
    else if (validade_alerta == 2 && aviso_validade > 12)
        swal("", "Número de meses excedido para a alerta de validade próxima. (Máximo 12 meses)", "warning");
    else if (validade_alerta == 3 && aviso_validade > 2)
        swal("", "Número de anos excedido para a alerta de validade próxima. (Máximo 2 anos)", "warning");
    else if (aviso_vencido == 1 && vencido_alerta > 30)
        swal("", "Número de dias excedido para a alerta após vencimento. (Máximo 30 dias)", "warning");
    else if (aviso_vencido == 2 && vencido_alerta > 12)
        swal("", "Número de meses excedido para a alerta após vencimento. (Máximo 12 meses)", "warning");
    else if (aviso_vencido == 3 && vencido_alerta > 2)
        swal("", "Número de anos excedido para a alerta após vencimento. (Máximo 2 anos)", "warning");
    else {
        var data = $('#aviso_form').serialize();
        swal({
            title: "<center>Aguarde</center>",
            html: true,
            imageUrl: "assets/img/loader.gif",
            showConfirmButton: false
        });
        var url = "alterar/gravar_usuario_config.php";
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data, status) {
                if (erroJSON(data.codigo) === 0) {
                    swal({
                        title: "",
                        text: "Salvo com sucesso",
                        type: "success"
                    });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function(data, status) {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    }
}

function gerar_relatorio() {
    var data = $('.relatorio').serialize();
    var url = "ajax/relatorio.php";
    swal({
        title: "<center>Aguarde</center>",
        html: true,
        imageUrl: "assets/img/loader.gif",
        showConfirmButton: false
    });
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function(data, status) {
            if (erroJSON(data.codigo)) {
                swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
            } else {
                if (Number(data.length)) {
                    swal.close();
                    $('.relatorio').slideUp();
                    $('.relatorio_gerado').slideDown();
                    $table = $('.table-relatorio tbody');
                    $('.table-relatorio th').addClass('hidden');
                    $table.html('');
                    inc = 0;
                    var lines = '';
                    for (var i = data.length - 1; i >= 0; i--) {
                        var dados = data[i];
                        if (inc % 2) $table.append('<tr style="background:#dadada !important;" id="linha' + i + '" bgcolor="#dadada">');
                        else $table.append('<tr style="background:white !important;" id="linha' + i + '" bgcolor="white">');
                        $linha = $('#linha' + i);
                        if (dados.hasOwnProperty('nome')) {
                            $('.table-relatorio .nome').removeClass('hidden');
                            if ((dados.nome).length <= 12) var nome = dados.nome;
                            else var nome = ((dados.nome).trim()).substr(0, 12) + '...';
                            $linha.append('<td>' + tratar_vazio(nome) + '</td>');
                        }
                        if (dados.hasOwnProperty('quantidade')) {
                            $('.table-relatorio .quantidade').removeClass('hidden');
                            var quantidade = tratar_vazio(dados.quantidade);
                            if (tratar_vazio(dados.unidade_medida, false)) {
                                if (quantidade > 1)
                                    quantidade += ' ' + dados.unidade_medida + 's';
                                else
                                    quantidade += ' ' + dados.unidade_medida;
                            }
                            if (tratar_vazio(dados.fator, false)) {
                                quantidade += ' c/ ' + dados.fator + ' (UN)';
                            }
                            $linha.append('<td>' + quantidade + '</td>');
                        }
                        if (dados.hasOwnProperty('marca')) {
                            $('.table-relatorio .marca').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.marca) + '</td></tr>');
                        }
                        if (dados.hasOwnProperty('categoria')) {
                            $('.table-relatorio .categoria').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.categoria) + '</td>');
                        }
                        if (dados.hasOwnProperty('subcategoria')) {
                            $('.table-relatorio .subcategoria').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.subcategoria) + '</td>');
                        }
                        if (dados.hasOwnProperty('data_validade')) {
                            $('.table-relatorio .data_validade').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.data_validade, true, true) + '</td>');
                        }
                        if (dados.hasOwnProperty('data_cadastro')) {
                            $('.table-relatorio .data_cadastro').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.data_cadastro, true, true) + '</td>');
                        }
                        if (dados.hasOwnProperty('fornecedor')) {
                            $('.table-relatorio .fornecedor').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.fornecedor) + '</td>');
                        }
                        if (dados.hasOwnProperty('preco_custo')) {
                            $('.table-relatorio .preco_custo').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.preco_custo) + ' ' + tratar_vazio(dados.un_med_custo, false) + '</td>');
                        }
                        if (dados.hasOwnProperty('localizacao')) {
                            $('.table-relatorio .localizacao').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.localizacao) + '</td>');
                        }
                        if (dados.hasOwnProperty('lote')) {
                            $('.table-relatorio .lote').removeClass('hidden');
                            $linha.append('<td>' + tratar_vazio(dados.lote) + '</td>');
                        }
                        if (dados.hasOwnProperty('status')) {
                            $('.table-relatorio .notificacao').removeClass('hidden');
                            if (dados.status == 1) var status = 'Sim';
                            else var status = 'Não';
                            $linha.append('<td>' + tratar_vazio(status) + '</td>');
                        }
                        if (dados.hasOwnProperty('descricao')) {
                            $('.table-relatorio .descricao').removeClass('hidden');
                            var descricao = tratar_vazio(dados.descricao);
                            console.log(descricao);
                            if (descricao.length > 40) var descricao = descricao.substr(0, 41) + '...';
                            $linha.append('<td>' + descricao + '</td>');
                        }
                        inc++;
                    }
                    $('body').append('<div id="total_produtos" style="display: none;">' + inc + '</div>');
                } else {
                    swal({ title: '', text: 'Nenhum resultado foi encontrado', type: 'warning' });
                }
            }
        },
        error: function(data, status) {
            swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
        }
    });
}

function simple(v) {
    return v;
}

function tratar_vazio(text = '', extra = true, date = false) {
    if (text == null || text == undefined || text == '' || text == NaN) {
        if (extra) return '<span style="color:#979797;">Vazio</span>';
        else return '';
    } else {
        if (!date) return text;
        else return date_text(text);
    }
}

function date_text(data = '') {
    if (!data) return '';
    var ano = data.substr(0, 4);
    var mes = data.substr(5, 2);
    var dia = data.substr(8, 2);
    switch (mes) {
        case '01':
            mes = 'Janeiro';
            break;
        case '02':
            mes = 'Fevereiro';
            break;
        case '03':
            mes = 'Março';
            break;
        case '04':
            mes = 'Abril';
            break;
        case '05':
            mes = 'Maio';
            break;
        case '06':
            mes = 'Junho';
            break;
        case '07':
            mes = 'Julho';
            break;
        case '08':
            mes = 'Agosto';
            break;
        case '09':
            mes = 'Setembro';
            break;
        case '10':
            mes = 'Outubro';
            break;
        case '11':
            mes = 'Novembro';
            break;
        case '12':
            mes = 'Dezembro';
            break;
    }
    var date = dia + ' de ' + mes + ' de ' + ano;
    return date;
}

function imprimir_relatorio() {
    var total = $('#total_produtos').html();
    $('.relatorio_container').printThis({
        header: '<style>@media print{@page {size: landscape}} body, html { font-family: Arial; } td, th { text-align: left; padding: 6px; } .hidden { display: none; } tbody tr:nth-of-type(odd) { background-color: #dadada !important; }</style><div align="left" style="width:100%;"><img src="http://valix.com.br/app/assets/img/vale10_p.png" style="width:85px;" /></div><br /><table style="width:100%;"><thead><tr><td align="left">Total de Produtos: ' + total + '</td><td align="right" style="text-align:right !important;">www.valix.com.br</td></tr></thead></table><br />',
        importCSS: false,
        importStyle: true,
        footer: '<br />Gerado em: ' + date_text(hoje())
    });
}

function hoje() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var today = yyyy + '/' + mm + '/' + dd;

    return today;
}

function abrirGrafico() {
    $('#loader').fadeIn();
    $.pgwModal({
        url: 'listar/grafico.php',
        loadingContent: '<center style="font-size:18px"><br /><br />Carregando <i class="fa fa-circle-o-notch fa-spin"></i><br /><br /></center>',
        title: 'Gráfico',
        closeOnBackgroundClick: false,
        closable: false,
        mainClassName: 'pgwModal GraficoModal'
    });
}

function abrirHistoricoNovo() {
    $('#loader').fadeIn();
    $.pgwModal({
        url: 'listar/historico.php?lido=0',
        loadingContent: '<center style="font-size:18px"><br /><br />Carregando <i class="fa fa-circle-o-notch fa-spin"></i><br /><br /></center>',
        title: 'Histórico de Avisos - Não Lidos',
        closeOnBackgroundClick: false,
        closable: false,
        mainClassName: 'pgwModal GraficoModal'
    });
}

function abrirHistoricoLido() {
    $('#loader').fadeIn();
    $.pgwModal({
        url: 'listar/historico.php?lido=1',
        loadingContent: '<center style="font-size:18px"><br /><br />Carregando <i class="fa fa-circle-o-notch fa-spin"></i><br /><br /></center>',
        title: 'Histórico de Avisos - Lidos',
        closeOnBackgroundClick: false,
        closable: false,
        mainClassName: 'pgwModal GraficoModal'
    });
}

function limparHistoricoLido() {
    swal({
        title: "Você tem certeza?",
        text: "Não será possível desfazer a ação",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        var url = 'deletar/historico.php?target=lidos';
        $.ajax({
            url: url,
            dataType: 'JSON',
            success: function(data) {                
                if (erroJSON(data.codigo) === 0) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        window.onbeforeunload = function() {};
                        $('#loader').fadeIn();
                        abrirHistoricoLido();
                        swal.close();
                    });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function limparHistoricoNovo() {
    swal({
        title: "Você tem certeza?",
        text: "Não será possível desfazer a ação",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        var url = 'deletar/historico.php?target=novos';
        $.ajax({
            url: url,
            dataType: 'JSON',
            success: function(data) {                
                if (erroJSON(data.codigo) === 0) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        window.onbeforeunload = function() {};
                        $('#loader').fadeIn();
                        abrirHistoricoNovo();
                        swal.close();
                    });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}

function excluirAviso(id) {
    swal({
        title: "Você tem certeza?",
        text: "Não será possível desfazer a ação",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }, function() {
        var url = 'deletar/historico.php?target=unico&id='+id;
        $.ajax({
            url: url,
            dataType: 'JSON',
            success: function(data) {                
                if (erroJSON(data.codigo) === 0) {
                    swal({
                        title: "",
                        text: "Excluído com sucesso",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        window.onbeforeunload = function() {};
                        $('#loader').fadeIn();
                        abrirHistoricoNovo();
                        swal.close();
                    });
                } else {
                    swal({ title: '', text: '<div style="font-size:20px !important;margin-bottom: 8px;">' + mensagemErro(data.codigo) + '</div><small>Codigo do erro: ' + data.codigo + '</small>', type: 'error', html: true });
                }
            },
            error: function() {
                swal({ title: 'Ocorreu um erro!', text: 'Tente Novamente', type: 'error' });
            }
        });
    });
}
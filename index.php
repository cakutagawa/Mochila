<?php
require 'mochila-d.php';

if (isset($_POST['calculate'])) {
  extract($_POST);
  
  $mochila = new Knapsack($p);
  $table = $mochila->generateTable();#gera tabela
  $chosen = $mochila->generateChosenItemsTable();
}
?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Knapsack Problem</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <style type="text/css">
    .container-fluid {
      padding: 45px;
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="panel-heading">Knapsack</div>
          <form method="post" action="#">
            <input type="hidden" name="calculate" />
            <table class="table" id="ktable">
              <tbody>
                <tr>
                  <th colspan="3">Capacidade da mochila</th>
                </tr>
                <tr>
                  <td colspan="3"><input type="number" name="p[c]" value="<?=$p['c']?>" class="form-control" autocomplete="false" required></td>
                </tr>
                <tr>
                  <th>Peso</th>
                  <th>Valor</th>
                </tr>
                <?php if (!count($p['w'])): ?>
                <tr>
                  <td><input type="number" name="p[w][]" class="form-control" autocomplete="false" required></td>
                  <td><input type="number" name="p[v][]" class="form-control" autocomplete="false" required></td>
                  <td><button type="button" class="btn btn-block btn-danger rmv_item">x</button></td>
                </tr>
                <tr>
                  <td><input type="number" name="p[w][]" class="form-control" autocomplete="false" required></td>
                  <td><input type="number" name="p[v][]" class="form-control" autocomplete="false" required></td>
                  <td><button type="button" class="btn btn-block btn-danger rmv_item">x</button></td>
                </tr>
                <tr>
                  <td><input type="number" name="p[w][]" class="form-control" autocomplete="false" required></td>
                  <td><input type="number" name="p[v][]" class="form-control" autocomplete="false" required></td>
                  <td><button type="button" class="btn btn-block btn-danger rmv_item">x</button></td>
                </tr>
                <?php else: ?>
                  <?php foreach ($p['w'] as  $key => $value) : ?>
                  <tr>
                    <td><input type="number" name="p[w][]" value="<?=$value?>" class="form-control" autocomplete="false" required></td>
                    <td><input type="number" name="p[v][]" value="<?=$p['v'][$key]?>" class="form-control" autocomplete="false" required></td>
                    <td><button type="button" class="btn btn-block btn-danger rmv_item">x</button></td>
                  </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                  <td colspan="3"><button type="button" id="add_item" class="btn btn-block btn-primary">Adicionar item</button></td>
                </tr>
                <tr>
                  <td colspan="3"><button type="submit" id="calc" class="btn btn-block btn-lg btn-success">Calcular</button></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div><!-- end col-md-3 -->
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            Resultado
          </div>
          <div class="panel-body">
            <?php if (/*$chosen &&*/ $table): ?>
            <div id="result">
              <b>Itens selecionados:</b>
              <div class="table-responsive">
                <?=$chosen?>
              </div><!-- end table-responsive -->
            </div>  
            <b>Tabela:</b>
            <div class="table-responsive">
              <?=$table?>
            </div>
            <?php else: ?>
              <div class="alert alert-info">
                <strong>Atenc&atilde;o!</strong> &Eacute; necess&aacute;rio preencher os dados no formul&aacute;rio ao lado para visualizar algum resultado ;)
                se vc colocar itens de valor repetido, será considerado o de valor maior
              
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div><!-- end row -->

   </div><!-- end container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="knapsack.js"></script>
  </body>
</html>
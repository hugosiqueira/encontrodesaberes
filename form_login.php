		<form action="admin/index.php" method="post" >
			<fieldset>

                <h2>Entrar no sistema</h2>

                <hr class="colorgraph">

                <div class="form-group">

                  <input type="text" name="cpf"  data-mask="000.000.000-00" class="form-control input-lg" placeholder="Digite seu cpf">

                </div>

                <div class="form-group">

                  <input type="password" name="senha" class="form-control input-lg " placeholder="Digite sua senha">

                </div>
                 <hr class="colorgraph">
                 <?php if ( ! empty( $_SESSION['login_erro'] ) ) :?>
                        <div class="alert alert-error">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <?= $_SESSION['login_erro']; ?>
                        </div>
                          <?php $_SESSION['login_erro'] = ''; ?>
                      <?php endif; ?>

                  <div class="row">

                     <div class="col-xs-6 col-sm-6 col-md-6">

                      <input type="submit" class="btn btn-lg btn-success btn-block" value="Entrar">

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">

                      <a href="cadastros.php" class="btn btn-lg btn-primary btn-block">Cadastrar-se</a>

                    </div>

                  </div>

                  <span class="button-checkbox">

                   <a href="esqueceu.php" class="btn btn-link pull-right">Esqueceu sua senha?</a>

                 </span>

               </fieldset>
						
				
			
		</form>
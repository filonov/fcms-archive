<? require_once 'inc.header.php'; ?>
<body>

    <? require_once 'inc.menu.php'; ?>

    <div class="container">
	<div class="row">
	    <div class="span12">
		<h2>Витрина</h2>
	    </div>
	</div>

	<? if (!empty($error)): ?>
    	<div class="row ">    
    	    <div class="span12">
    		<div class="alert alert-error">
    		    <button type="button" class="close" data-dismiss="alert">&times;</button>
    		    <h4>Ошибка!</h4>
    		    {error}
    		</div>
    	    </div>
    	</div>
	<? endif; ?>



	<div class="row">

	    <form id="formdel" method="post" action="<?= current_url() ?>" class="form-inline">
		<div class="span12">
		    <button class="btn btn-primary save" type="submit"><i class="icon-ok"></i> Сохранить</button>
		    <table class="table table-hover">
			<thead>
			    <tr>
				<th class="span1">ID</th>
				<th class="span3">Порядковый номер</th>       
				<th class="span8">Название</th>  
			    </tr>
			</thead>
			<tbody>
			    <? foreach ($content as $item): ?>
    			    <tr>                                       
    				<td><?= $item->id ?></td>
    				<td>
				    <input type="number" 
    					   class="span3" 
    					   name="showcase_order[<?= $item->id ?>]" 
    					   value="<?= $item->showcase_order ?>"/>
				</td> 
    				<td><?= $item->title ?></td>   
    			    </tr>
			    <? endforeach; ?>
			</tbody>
		    </table>
		    <button class="btn btn-primary save" type="submit"><i class="icon-ok"></i> Сохранить</button>
		</div>
	    </form>
	</div>
	<? require_once 'inc.footer.php'; ?>            



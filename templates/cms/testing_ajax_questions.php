<? if (!empty($error)): ?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Ошибка сохранения!</h4>
        <br/><?= $error ?>
    </div>
<? endif; ?>
<table class="table table-hover table-condensed">
    <thead>
        <tr>
            <th class="span1">#</th>
	    <th class="span2">Номер</th>
	    <th class="span7">Вопрос</th>
	    <th class="span1">Операции</th>
        </tr>
    </thead>
    <tbody>
	<? foreach ($questions as $question): ?>
    	<tr>
		<? /*
		  <td><input type="checkbox" name="check[]" id="check-<?= $question->id ?>" value="<?= $question->id ?>"/></td>
		  <td><a href="#"><?= $question->number ?></a></td>
		  <td><a href="#"><?= $question->title ?></a></td>
		 */ ?>
    	    <td><?= $question->id ?></td>
    	    <td><a class="q_edit" href="#" onclick="get_q(<?= $question->id ?>,<?= $page_id ?>);"><?= $question->number ?></a></td>
    	    <td><a class="q_edit" href="#" onclick="get_q(<?= $question->id ?>,<?= $page_id ?>);"><?= $question->title ?></a></td>
    	    <td><a class="q_del btn btn-mini" href="#" onclick="del_q(<?= $question->id ?>,<?= $page_id ?>);"><i class="icon-trash"></i> Удалить</a></td>
    	</tr>
	<? endforeach; ?>
    </tbody>
</table>
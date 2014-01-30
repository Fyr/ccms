</div><div class="row-fluid">

	<div class="span8 offset2">
		<h3 class="text-center">Заголовок формы</h3>
		<form class="form">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				В вашей форме обнаружены ошибки ! <br>
				Поле "Имя" не может быть пустым
			</div>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Поздравляем!</strong> Вы успешно прочитали это сообщение.
			</div>
			<fieldset class="fieldset hidden-fildset">
				<legend>
					<a href="#" class="open-fieldset"><i class="icon-open"></i>Field Set closed</a>
				</legend>
				<div class="fieldset-content hide">
					<div class="controls-row control-group">
						<div class="span4 text-right">
							<label for="input6" class="control-label">
								Обычное текстовое поле
							</label>
						</div>
						<div class="span7 controls">
							<input type="text" class="span12 " id="input6">

							<div class="help-block">Пример вспомогательного текста</div>
						</div>
					</div>
					<div class="controls-row control-group">
						<div class="span4 text-right">
							<label for="input7" class="control-label">
								Обычное текстовое поле
							</label>
						</div>
						<div class="span7 controls">
							<input type="text" class="span12 " id="input7">

							<div class="help-block">Пример вспомогательного текста</div>
						</div>
					</div>
					<div class="controls-row control-group">
						<div class="span4 text-right">
							<label for="input8" class="control-label">
								Обычное текстовое поле
							</label>
						</div>
						<div class="span7 controls">
							<input type="text" class="span12 " id="input8">

							<div class="help-block">Пример вспомогательного текста</div>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="controls-row control-group error">
				<div class="span4 text-right">
					<label for="input15" class="control-label">Текстовое поле c ошибкой</label>
				</div>
				<div class="span7">
					<input type="text" class="span12" id="input15">
					<small class="pull-left control-label">Текст ошибки</small>
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					<label for="input17">Текстовое поле</label>
				</div>
				<div class="span7">
					<input type="email" class="span12" id="input17">
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					<span>Checkboxes</span>
				</div>
				<div class="span7">
					<label class="checkbox">
						<input type="checkbox"> Нажми здесь и выдели checkbox
					</label>
					<label class="checkbox">
						<input type="checkbox"> Нажми здесь и выдели checkbox2
					</label>
					<label class="checkbox">
						<input type="checkbox"> Нажми здесь и выдели checkbox3
					</label>
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					<span>Radio-buttons</span>
				</div>
				<div class="span7">
					<label class="radio">
						<input type="radio" name="demoradio" checked>
						Радио 1
					</label>
					<label class="radio">
						<input type="radio" name="demoradio">
						Радио 2
					</label>
					<label class="radio">
						<input type="radio" name="demoradio">
						Радио 3
					</label>
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					<span>Radio-buttons inline</span>
				</div>
				<div class="span7">
					<label class="radio inline">
						<input type="radio" name="demoradio2" >
						Радио 1
					</label>
					<label class="radio inline">
						<input type="radio" name="demoradio2">
						Радио 2
					</label>
					<label class="radio inline">
						<input type="radio" name="demoradio2" checked>
						Радио 3
					</label>

				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					<span>SelectBox</span>
				</div>
				<div class="span7">
					<select>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
					</select>
				</div>
			</div>

			<div class="controls-row control-group">
				<div class="span4 text-right">
					<label for="dateinput">Date</label>
				</div>
				<div class="span7">
					 <input type="text" id="dateinput" class="date span4">
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					 <label for="input-time">
						 Time
					 </label>
				</div>
				<div class="span7">
					 <input class="span4 time" placeholder="hh:mm"  id="input-time" type="text">
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					 <label for="inputt-numeric">
						 Number
					 </label>
				</div>
				<div class="span7">
					 <input type="number" id="inputt-numeric" class="span4">
				</div>
			</div>
			<div class="controls-row control-group">
				<div class="span4 text-right">
					 <label for="textarea">Textarea</label>
				</div>
				<div class="span7">
					  <textarea rows="5" id="textarea" class="span12"></textarea>
				</div>
			</div>

			<div class="controls-row control-group ">
				<div class="span12 text-center">
					<button class="btn btn-success">Another Action</button>
					<button class="btn btn-primary">Main Action</button>
					<button class="btn">Cancel</button>
				</div>
			</div>

		</form>
	</div>


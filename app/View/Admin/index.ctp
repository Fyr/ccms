
	<div class="span12">
		<h3 class="text-center">Заголовок h1 перед таблицей</h3>
		<table class="grid table-bordered">
			<thead>
			<tr class="first table-gradient">
				<th>
					<input type="checkbox" rel="tooltip" title="Select All" id="selectAll">
				</th>
				<th class="nowrap">
					<a class="icon-add" href="#" rel="tooltip" title="Add"></a>
					<a class="icon-show" href="#" rel="tooltip" title="Show filter settings" id="show-filter"></a>
				</th>
				<th class="nowrap">
					<a href="#" class="desc">Date</a>
				</th>
				<th>
					<a href="#" class="asc" rel="tooltip" title="Sort field Aaa ascending (0..9, A..Z)">Название</a>
				</th>
				<th>
					<a href="#" class="asc" rel="tooltip" title="Order by textfield2">Текстовое поле 2</a>
				</th>
				<th>
					<a href="#">Published</a>
				</th>
				<th>
					<a href="#">Numeric</a>
				</th>
			</tr>
			<tr id="greed-filter" class="hide">
				<th></th>
				<th>
					<a class="icon-in-bg icon-accept-filter" href="#" rel="tooltip" title="Apply filter setting"></a>
					<a class="icon-in-bg icon-clear-filter" href="#" rel="tooltip" title="Clear filter setting"></a>
				</th>
				<th class="nowrap">
					<input type="text" class="date">
				</th>
				<th>
					<input type="text" title="Enter title mask (* - any char)" rel="tooltip" class="biginput">
				</th>
				<th>
					<select class="input-small">
						<option></option>
						<option>Yes</option>
						<option>No</option>
					</select>
				</th>
				<th>
					<select class="input-small">
						<option></option>
						<option>Yes</option>
						<option>No</option>
					</select>
				</th>
			</tr>
			</thead>
			<tbody>
<?
	foreach ($aArticles as $row) {
?>
			<tr>
				<td class="align-center"><input type="checkbox" class="checkthis"></td>
				<td class="nowrap aling-center">
					<a href="#" title="edit"><i class="icon-edit"></i></a>
					<a href="#" title="delete"><i class="icon-delete"></i></a>
					<a href="#" onclick="return false" class="show-popover-content"><i class="icon-info"></i></a>
					<div class="popover-content hide">
						<p>Душа моя озарена неземной радостью, как эти чудесные весенние утра, которыми я наслаждаюсь от всего сердца. </p>
						<img src="img/glyphicons-halflings.png" width="150px">

						<p>Я совсем один и блаженствую в здешнем краю, словно созданном для таких, как я. Я так счастлив, мой друг, так упоен ощущением покоя, что искусство мое страдает от этого.</p>

						<p>Я совсем один и блаженствую в здешнем краю, словно созданном для таких, как я. Я так счастлив, мой друг, так упоен ощущением покоя, что искусство мое страдает от этого.</p>
					</div>
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-edit"></i> Действие 1</a></li>
							<li><a href="#"><i class="icon-star"></i> Действие 2</a></li>
						</ul>
					</div>
				</td>
				<td class="nowrap">
					<?=$row['Article']['created']?>
				</td>
				<td class="format-text">
					<span><?=$row['Article']['title']?></span>
				</td>
				<td class="format-text">
					<span><?=$row['Article']['teaser']?></span>
				</td>
				<td class="align-center">
					<i class="icon-in-bg icon-check"></i>
				</td>
				<td class="align-rigth nowrap">
					<?=$row['Article']['id']?>
				</td>
			</tr>
<?
	}
?>
			<tr id="last-tr" class="table-gradient ">
				<td colspan="10" class="nowrap">
					<table>
						<tr>
							<td style="width: 30%">
								<div id="do-anithing" class="hide">
									<small></small>
									<div class="btn-group">
										<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="#"><i class="icon-edit"></i> Действие 1</a></li>
											<li><a href="#"><i class="icon-star"></i> Действие 2</a></li>
										</ul>
									</div>
								</div>
							</td>
							<td style="width: 40%" class="align-center">
								<span>Страница:</span>
								<a href="#" title="first"><i class="icon-first"></i></a>
								<a href="#" title="prev"><i class="icon-prev"></i></a>
								<input type="text" value="1" style="width: 17px;">
								<a href="#" title="next"><i class="icon-next"></i></a>
								<a href="#" type="last"><i class="icon-last"></i></a>
								<span>Показать по:</span>
								<select>
									<option>10</option>
									<option>20</option>
									<option>30</option>
									<option>40</option>
								</select>
								<span>на странице</span>
							</td>
							<td style="width: 30%" class="align-right">
								<span>Просмотр 1 - 10 из 172 записей</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
	</div>


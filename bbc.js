//Depandances: controls.js

function getBBCodeCommandTag(field_id, onclick, onmouseover, pic_img){
	tag = createElementWithAttrs('a', new Array(
		{name:'href', val:'javascript:void(0);'},
		{name:'onclick', val:onclick.replace(/%s/,field_id)},
		{name:'onmouseover', val:onmouseover}
		));
	tag.appendChild(createImgElement(pic_img));
	return tag;
}
function addColorsToSelect(select){
	addOptionToSelectElement(select, '', 'Цвет текста');
	addOptionToSelectElement(select, "Black",'Черный');
	addOptionToSelectElement(select, "Red",'Красный');
	addOptionToSelectElement(select, "Yellow",'Желтый');
	addOptionToSelectElement(select, "Pink",'Розовый');
	addOptionToSelectElement(select, "Green",'Зеленый');
	addOptionToSelectElement(select, "Orange",'Оранжевый');
	addOptionToSelectElement(select, "Purple",'Пурпурный');
	addOptionToSelectElement(select, "Blue",'Синий');
	addOptionToSelectElement(select, "Beige",'Бежевый');
	addOptionToSelectElement(select, "Brown",'Коричневый');
	addOptionToSelectElement(select, "Teal",'Бирюзовый');
	addOptionToSelectElement(select, "Navy",'Фиолетовый');
	addOptionToSelectElement(select, "Maroon",'Темно-красный');
	addOptionToSelectElement(select, "LimeGreen",'Светло-зеленый');
}

function addBBCode(html_body, field_id){
	html_body.appendChild(createExtScriptElement(EXT_BBC_EDITOR));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[b]', '[/b]', document.getElementById('%s')); return false;", "helpline('bold');", BBCodePictures.PIC_BOLD));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[i]', '[/i]', document.getElementById('%s')); return false;", "helpline('italic');", BBCodePictures.PIC_ITALIC));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[u]', '[/u]', document.getElementById('%s')); return false;", "helpline('underline');", BBCodePictures.PIC_UNDERLINE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[s]', '[/s]', document.getElementById('%s')); return false;", "helpline('strike');", BBCodePictures.PIC_STRIKE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[pre]', '[/pre]', document.getElementById('%s')); return false;", "helpline('pre');", BBCodePictures.PIC_PRE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[left]', '[/left]', document.getElementById('%s')); return false;", "helpline('left');", BBCodePictures.PIC_LEFT));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[center]', '[/center]', document.getElementById('%s')); return false;", "helpline('center');", BBCodePictures.PIC_CENTER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[right]', '[/right]', document.getElementById('%s')); return false;", "helpline('right');", BBCodePictures.PIC_RIGHT));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[hr]', '', document.getElementById('%s')); return false;", "helpline('hr');", BBCodePictures.PIC_HR));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[size=12]', '[/size]', document.getElementById('%s')); return false;", "helpline('size');", BBCodePictures.PIC_SIZE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[font=Verdana]', '[/font]', document.getElementById('%s')); return false;", "helpline('font');", BBCodePictures.PIC_FONT));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[table]', '[/table]', document.getElementById('%s')); return false;", "helpline('table');", BBCodePictures.PIC_TABLE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[tr]', '[/tr]', document.getElementById('%s')); return false;", "helpline('tr');", BBCodePictures.PIC_TR));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[td]', '[/td]', document.getElementById('%s')); return false;", "helpline('td');", BBCodePictures.PIC_TD));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[sup]', '[/sup]', document.getElementById('%s')); return false;", "helpline('sup');", BBCodePictures.PIC_SUP));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[sub]', '[/sub]', document.getElementById('%s')); return false;", "helpline('sub');", BBCodePictures.PIC_SUB));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[code]', '[/code]', document.getElementById('%s')); return false;", "helpline('code');", BBCodePictures.PIC_CODE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[quote]', '[/quote]', document.getElementById('%s')); return false;", "helpline('quote');", BBCodePictures.PIC_QUOTE));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[list]\n[li]\n[li]\n', '[/li]\n[/li]\n[/list]', document.getElementById('%s')); return false;", "helpline('list');", BBCodePictures.PIC_LIST));
	html_body.appendChild(getBBCodeCommandTag(field_id, "", BBCodePictures.PIC_DIVIDER));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[img]', '[img/]', document.getElementById('%s')); return false;", "helpline('img');", BBCodePictures.PIC_IMG));
	html_body.appendChild(getBBCodeCommandTag(field_id, "surroundText('[url]', '[url/]', document.getElementById('%s')); return false;", "helpline('url');", BBCodePictures.PIC_URL));
	html_body.appendChild(createElementWithAttrs('br', new Array(0)));
	
	html_body.appendChild(document.createTextNode('Цвет текста:'));
	onchange = "surroundText('[color=' + this.options[this.selectedIndex].value.toLowerCase() + ']', '[/color]', document.getElementById('%s')); this.selectedIndex = 0; document.getElementById('%s').focus(document.getElementById('%s').caretPos);";
	onchange.replace(/%s/,field_id);	
	select = createElementWithAttrs('select', new Array(
					{name:'onchange',val:onchange},
					{name:'onmouseover', val:"helpline('fontcolor')"},
					{name:'class', val:"form_elements_dropdown"}
				));
	addColorsToSelect(select);
	html_body.appendChild(select);
	
	html_body.appendChild(document.createTextNode('Цвет фона:'));
	onchange = "surroundText('[bgcolor=' + this.options[this.selectedIndex].value.toLowerCase() + ']', '[/bgcolor]', document.getElementById('%s')); this.selectedIndex = 0; document.getElementById('%s').focus(document.getElementById('%s').caretPos);";
	onchange.replace(/%s/,field_id);
	select = createElementWithAttrs('select', new Array(
					{name:'onchange',val:onchange},
					{name:'onmouseover', val:"helpline('fontcolor')"},
					{name:'class', val:"form_elements_dropdown"}
				));
	addColorsToSelect(select);
	html_body.appendChild(select);	
}

function surroundText(text1, text2, textarea){
	//var val = textarea.value;	
	//textarea.value = val+text1+''+text2;	
	//textarea.focus();
	//******************
	// Can a text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange){
		var caretPos = textarea.caretPos, temp_length = caretPos.text.length;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text1 + caretPos.text + text2 + ' ' : text1 + caretPos.text + text2;
		if (temp_length == 0){
			caretPos.moveStart("character", -text2.length);
			caretPos.moveEnd("character", -text2.length);
			caretPos.select();
		}
		else
			textarea.focus(caretPos);
	}
	// Mozilla text range wrap.
	else if (typeof(textarea.selectionStart) != "undefined"){
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;
		textarea.value = begin + text1 + selection + text2 + end;
		if (textarea.setSelectionRange){
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length, newCursorPos + text1.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put them on the end, then.
	else
	{
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}		
}
//Helpbox messages
bold_help = "Полужирный: [b] текст [/b]";
italic_help = "Курсив: [i] текст [/i]";
underline_help = "Подчеркнутый: [u] текст [/u]";
strike_help = "Зачеркнутый: [strike]текст [/strike]";
pre_help = "Выровненный текст: [pre] текст [/pre]";
left_help = "По левому краю: [left] текст [/left]";
right_help = "По правому краю: [right] текст [/right]";
center_help = "По центру: [center] текст [/center]";
hr_help = "Линия: [hr]";
size_help = "Размер шрифта: [size=5] текст [/size]";
face_help = "Шрифт: [font=Verdana] текст [/font]";
table_help = "Таблица: [table] строки и ячейки [/table]";
tr_help = "Строка таблицы: [tr] ячейки [/tr]";
td_help = "Ячейка таблицы: [td] текст ячейки [/td]";
sup_help = "Надстрочный: [sup] текст [/sup]";
sub_help = "Подстрочный: [sub] текст [/sub]";
code_help = "Код символа: [code] текст [/code]";
quote_help = "Цитата: [quote] текст [/quote]";
list_help = "Список: [list] [li]текст [/li] [/list]";
img_help = "Картинка: [img]http://image_url [/img]";
url_help = "Ссылка: [url] http://url [/url] или [url=http://url] ткст ссылки [/url]";
fontcolor_help = "Цвет шрифта: [color=red] текст [/color]";
bgcolor_help = "Цвет фона: [bgcolor=red] текст [/bgcolor]";

//Function for displaying help information
// Shows the help messages in the helpline window
function helpline(help) {
        var helpbox = document.forms[0].helpbox;
        helpbox.value = eval(help + "_help");
}

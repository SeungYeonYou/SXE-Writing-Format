<?php
	if(!defined("__XE__")) exit();
	if(Context::get('module')=='admin' && $called_position != 'before_display_content' && $called_position != 'before_module_init'){return;}

	/**
	* @addon sxe_writing_format.addon.php
	* @author SeungXE (SeungYeonYou.KR+XE@gmail.com)
	* @brief 글 양식 애드온
	**/

	if($called_position == 'before_display_content' && Context::getResponseMethod() == 'HTML' && Context::get('act')=='dispBoardWrite') {
		if(strpos($output,'<input type="hidden" name="content" value="" />')!==false){
			$output = str_replace('<input type="hidden" name="content" value="" />','<input type="hidden" name="content" value="'.htmlentities($addon_info->format,ENT_QUOTES | ENT_IGNORE, 'UTF-8').'" />',$output);
		}
	}
?>
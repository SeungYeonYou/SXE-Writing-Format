<?php
	if(!defined("__XE__")) exit();
	if(Context::get('document_srl')) return;
	if(Context::get('module')=='admin' && $called_position != 'before_display_content' && $called_position != 'before_module_init'){return;}

	/**
	* @addon sxe_writing_format.addon.php
	* @author SeungXE (SeungYeonYou.KR+XE@gmail.com)
	* @brief 글 양식 애드온
	**/

	if($called_position == 'before_display_content' && Context::getResponseMethod() == 'HTML' && Context::get('act')=='dispBoardWrite') {
		function sxe_setFormat($by,$cont){
			if($by=='php'){
				if(strpos($output,'<input type="hidden" name="content" value="" />')!==false){
					$output = str_replace('<input type="hidden" name="content" value="" />','<input type="hidden" name="content" value="'.htmlentities($cont,ENT_QUOTES | ENT_IGNORE, 'UTF-8').'" />',$output);
				}
			}else{
				Context::addHTMLFooter('<script>jQuery("input[name=content]").val("'.htmlentities($cont,ENT_QUOTES | ENT_IGNORE, 'UTF-8').'");</script>');
			}
		};
		
		if($addon_info->to_apply==all){
			// 전체 적용시에 작동.
			sxe_setFormat($addon_info->method,$addon_info->template_1);
			return;
		}
		//mid 값을 context에서 받아온다.
		$mid = Context::get('mid');
		//write_method (입력 방법)에 따라 템플릿을 가져온다.
		if($addon_info->write_method=='simple'){
			for($i=1; $i<6; $i++){
				$mid_arg = 'use_mid_'.$i;
				$template_arg = 'template_'.$i;
				Context::addHTMLFooter('<!--['.$addon_info->$mid_arg.']-->');
					if(strpos($addon_info->$mid_arg,$mid)!==false){
						$sxe_template = $addon_info->$template_arg;
					}
			}
		}elseif($addon_info->write_method=='json'){
			$json = json_decode($addon_info->json,true);
			//var_dump($json);
			foreach($json['apply'] as $k => $v){
				foreach($v as $val){
					if($mid==$val){
						$sxe_template = $json['contents'][$k];
					}
				}
			}
		}
		//템플릿이 없으면 = mid가 일치하지 않았다면 리턴시켜버림.
		if(!$sxe_template){return;} elseif($sxe_template) {
			sxe_setFormat($addon_info->method,$sxe_template);
		}
	}
?>

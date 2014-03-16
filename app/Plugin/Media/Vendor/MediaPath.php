<?
class MediaPath {

    function getSizeInfo($size) {
    	$_ret = array();
    	if ($size && strpos($size, 'x') !== false) {
    		$_ret = array('w' => null, 'h' => null);

    		$aSize = explode('x', $size);
    		if (isset($aSize[0]) && $aSize[0]) {
    			$_ret['w'] = $aSize[0];
    		}
    		if (isset($aSize[1]) && $aSize[1]) {
    			$_ret['h'] = $aSize[1];
    		}
    	}
    	return $_ret;
    }

    function getFileInfo($filename) {
		$aFName = explode('.', $filename);
		$_ret = array('fname' => $aFName[0], 'orig_fname' => $aFName[0], 'orig_ext' => $aFName[1]);
		if (isset($aFName[2]) && $aFName[2]) {
			$_ret['ext'] = $aFName[2];
		} else {
			$_ret['ext'] = $aFName[1];
		}
		return $_ret;
    }

    function getFileName($type, $id, $size, $filename) {
    	$aFName = $this->getFileInfo($filename);
    	$aSize = $this->getSizeInfo($size);
    	$_ret = $this->getPath($type, $id);
    	if ($aSize) {
    		$_ret.= $aSize['w'].'x'.$aSize['h'].'.'.$aFName['ext'];
    	} else {
    		$_ret.= $filename;
    	}
    	return $_ret;
    }

    function getPath($type, $id) {
		return $this->getPagePath($type, $id).$id.'/';
    }

    function getPagePath($type, $id) {
    	$page = floor($id/100);
		$path = $this->getTypePath($type).$page.'/';
		return $path;
    }
    
    function getTypePath($type) {
        return PATH_FILES_UPLOAD.strtolower($type).'/';
    }

    function getImageUrl($type, $id, $size, $filename) {
    	if (!$size) {
    		$size = 'noresize';
    	}
		return '/media/router/index/'.$type.'/'.$id.'/'.$size.'/'.$filename;
    }

    function getRawUrl($type, $id, $filename) {
    	$page = floor($id/100);
    	return '/files/'.$type.'/'.$page.'/'.$id.'/'.rawurlencode($filename);
    }

}

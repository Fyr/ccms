<?php
App::uses('AppModel', 'Model');
class Media extends AppModel {
    const MKDIR_MODE = 0755;
    
    public $types = array('image', 'audio', 'video', 'bin_file');
    
    
    /*public function beforeSave($options = array()) {
        
    }
    */
    
    /**
     * Uploades media file into auto-created folder
     *
     * @param array $data - array. Must contain elements: 'media_type', 'object_type', 'object_id', 'tmp_name', 'file', 'ext'
     *                      tmp_name - temp file to rename to media folders
     *                      file.ext - final name of file
     */
    public function uploadMedia($data) {
        App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();
		$this->save($data);
		$id = $this->id;
		
		extract($data);
		
		// Create folders if not exists
		$path = $this->PHMedia->getTypePath($object_type);
		if (!file_exists($path)) {
		    mkdir($path, self::MKDIR_MODE);
		}
		$path = $this->PHMedia->getPagePath($object_type, $id);
		if (!file_exists($path)) {
		    mkdir($path, self::MKDIR_MODE);
		}
		$path = $this->PHMedia->getPath($object_type, $id);
		mkdir($path, self::MKDIR_MODE);
		
		// TODO: handle rename error
		$res = rename($tmp_name, $path.$file.$ext);
		if ($res) {
		    // remove auto-thumb
		    $path = pathinfo($tmp_name);
		    @unlink($path['dirname'].'/thumbnail/'.$path['basename']);
		}
    }
    
    public function getList($findData = array(), $order = 'Media.id DESC') {
        $aRows = $this->find('all', array('conditions' => $findData, 'order' => $order));
        App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();
        foreach($aRows as &$_row) {
            $row = $_row['Media'];
            $_row['Media']['image'] = $this->PHMedia->getImageUrl($row['object_type'], $row['id'], '100x80', $row['file'].$row['ext']);
        }
        return $aRows;
    }
    
    /*
    public function typeOf($mediaRow) {
        return (isset($mediaRow['Media']) && isset($mediaRow['Media']['media_type'])) ? $mediaRow['Media']['media_type'] : '';
    }
    */
    
    /* public function getImageList($object_id = null, $object_type = null) {
        
    }
    */
}

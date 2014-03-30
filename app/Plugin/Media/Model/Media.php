<?php
App::uses('AppModel', 'Model');
class Media extends AppModel {
    const MKDIR_MODE = 0755;
    
    public $types = array('image', 'audio', 'video', 'bin_file');
    protected $PHMedia;

    protected function _afterInit() {
    	App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();
    }
    
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
    
    /**
     * Return list of media data with additional stats
     *
     * @param array $findData - conditions
     * @param mixed $order
     * @return array
     */
    public function getList($findData = array(), $order = array('Media.main' => 'DESC', 'Media.id' => 'DESC')) {
        $aRows = $this->find('all', array('conditions' => $findData, 'order' => $order));
        foreach($aRows as &$_row) {
            $row = $_row['Media'];
            $_row['Media']['image'] = $this->PHMedia->getImageUrl($row['object_type'], $row['id'], '100x80', $row['file'].$row['ext']);
            $_row['Media']['file_size'] = filesize($this->PHMedia->getFileName($row['object_type'], $row['id'], '', $row['file'].$row['ext']));
        }
        return $aRows;
    }
    
    /*
    public function typeOf($mediaRow) {
        return (isset($mediaRow['Media']) && isset($mediaRow['Media']['media_type'])) ? $mediaRow['Media']['media_type'] : '';
    }
    */
	
	public function setMain($id , $object_type = null, $object_id = null) {
		// Clear main flag for all media
		if ($object_id && $object_type) {
			$this->updateAll(array('main' => 0), compact('object_type', 'object_id'));
			fdebug(array('main' => 0));
		} else {
			$media = $this->findById($id);
			$this->setMain($id, $media['Media']['object_type'], $media['Media']['object_id']);
			return;
		}
		$this->save(array('id' => $id, 'main' => 1));
	}
	
    /**
     * Removes actual media-files before delete a record
     *
     * @param bool $cascade
     * @return bool
     */
	public function beforeDelete($cascade = true) {
		App::uses('Path', 'Core.Vendor');
		
		$media = $this->findById($this->id);
		$path = $this->PHMedia->getPath($media['Media']['object_type'], $this->id);

		if (file_exists($path)) {
			// remove all files in folder
			$aPath = Path::dirContent($path);
			if (isset($aPath['files']) && $aPath['files']) {
				foreach($aPath['files'] as $file) {
					unlink($aPath['path'].$file);
				}
			}
			rmdir($path);
		}
		return true;
	}
}

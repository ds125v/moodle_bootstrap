<?php
/* some documentation here */

class theme_bootstrap_core_renderer extends core_renderer {
     
 	public function hello_world() {
 		return "hello world";
 	}
 	
	protected function render_custom_menu(custom_menu $menu) {
		// If the menu has no children return an empty string
		if (!$menu->has_children()) {
			return '';
		}
		// Initialise this custom menu
		$content = html_writer::start_tag('div',array('class'=>"navbar navbar-fixed-top"));
		$content .= html_writer::start_tag('div',array('class'=>"navbar-inner"));
		$content .= html_writer::start_tag('div',array('class'=>"container"));
		$content .= html_writer::start_tag('ul', array('class'=>'nav'));
		// Render each child
		foreach ($menu->get_children() as $item) {
			$content .= $this->render_custom_menu_item($item);
		}
		// Close the open tags
		$content .= html_writer::end_tag('ul');
		$content .= html_writer::end_tag('div');
		$content .= html_writer::end_tag('div');
		$content .= html_writer::end_tag('div');
		// Return the custom menu
		return $content;
	}

	protected function render_custom_menu_item(custom_menu_item $menunode) {
		// Required to ensure we get unique trackable id's
		static $submenucount = 0;
		
		if ($menunode->has_children()) {
		    $content = html_writer::start_tag('li', array('class'=>'dropdown'));
			// If the child has menus render it as a sub menu
			$submenucount++;
			if ($menunode->get_url() !== null) {
				$url = $menunode->get_url();
			} else {
				$url = '#cm_submenu_'.$submenucount;
			}
			
			//$content .= html_writer::link($url, $menunode->get_text(), array('title'=>,));
			$content .= html_writer::start_tag('a', array('href'=>$url,'class'=>'dropdown-toggle','data-toggle'=>'dropdown'));
			$content .= $menunode->get_title();
			$content .= html_writer::start_tag('b', array('class'=>'caret'));
			$content .= html_writer::end_tag('b');
			$content .= html_writer::end_tag('a');
			$content .= html_writer::start_tag('ul', array('class'=>'dropdown-menu'));
			foreach ($menunode->get_children() as $menunode) {
				$content .= $this->render_custom_menu_item($menunode);
			}
			$content .= html_writer::end_tag('ul');
		} else {
		    $content = html_writer::start_tag('li');
			// The node doesn't have children so produce a final menuitem

			if ($menunode->get_url() !== null) {
				$url = $menunode->get_url();
			} else {
				$url = '#';
			}
			$content .= html_writer::link($url, $menunode->get_text(), array('title'=>$menunode->get_title()));
		}
		$content .= html_writer::end_tag('li');
		// Return the sub menu
		return $content;
	}
	
    protected function render_pix_icon(pix_icon $icon) {
        $attributes = $icon->attributes;
        $attributes['src'] = $this->pix_url($icon->pix, $icon->component);
        $iconset = array('i/edit' => 'icon-pencil',
        'i/settings' => 'icon-list-alt',
        'i/group' => 'icon-user',
        'i/backup' => 'icon-cog',
        'i/restore' => 'icon-cog',
        'i/navigationitem' => 'icon-chevron-right');
        
        
        if (isset($iconset[$icon->pix])) {
            return '<div class = "'.$iconset[$icon->pix].' bootstrapicon"></div>';
        } else {
            //debug: return html_writer::empty_tag('img', $attributes) . $icon->pix;
            return html_writer::empty_tag('img', $attributes) . $icon->pix;
        }
        
        
    }
    
 		
}
?>

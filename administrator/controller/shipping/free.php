<?php
class ControllerShippingFree extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load_language('shipping/free');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('free', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/free', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => $this->language->get('text_breadcrumb_separator')
   		);
		
		$this->data['action'] = $this->url->link('shipping/free', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
	
		if (isset($this->request->post['free_total'])) {
			$this->data['free_total'] = $this->request->post['free_total'];
		} else {
			$this->data['free_total'] = $this->config->get('free_total');
		}

		if (isset($this->request->post['free_geo_zone_id'])) {
			$this->data['free_geo_zone_id'] = $this->request->post['free_geo_zone_id'];
		} else {
			$this->data['free_geo_zone_id'] = $this->config->get('free_geo_zone_id');
		}
		
		if (isset($this->request->post['free_status'])) {
			$this->data['free_status'] = $this->request->post['free_status'];
		} else {
			$this->data['free_status'] = $this->config->get('free_status');
		}
		
		if (isset($this->request->post['free_description'])) {
			$this->data['free_description'] = $this->request->post['free_description'];
		} else {
			$this->data['free_description'] = $this->config->get('free_description');
		}
		
		if (isset($this->request->post['free_sort_order'])) {
			$this->data['free_sort_order'] = $this->request->post['free_sort_order'];
		} else {
			$this->data['free_sort_order'] = $this->config->get('free_sort_order');
		}				
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
								
		$this->template = 'shipping/free.tpl';
		$this->id = 'content';
		$this->layout = 'layout/default';
		$this->render();
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/free')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
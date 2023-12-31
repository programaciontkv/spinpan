<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura_model extends CI_Model {


	public function lista_facturas(){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->order_by('fac_numero');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_facturas_empresa_emisor($emp_id,$emi_id){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('emi_id',$emi_id);
		$this->db->order_by('fac_numero','desc');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_factura_buscador($text,$f1,$f2,$emp_id,$emi_id){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('emi_id',$emi_id);
		$this->db->order_by('fac_numero','desc');
		$this->db->where("(fac_numero like '%$text%' or fac_nombre like '%$text%' or fac_identificacion like '%$text%') and fac_fecha_emision between '$f1' and '$f2'", null);
		$this->db->order_by('fac_numero','desc');
		$resultado=$this->db->get();
		return $resultado->result();
	}

	public function lista_secuencial_documento($emi,$cja){
		$this->db->select('fac_numero');
		$this->db->from('erp_factura');
		$this->db->where('emi_id',$emi);
		$this->db->where('cja_id',$cja);
		$this->db->order_by('fac_numero','desc');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}


	public function lista_productos(){
		$this->db->from('erp_mp p');
		$this->db->where('p.mp_i','1');
		$this->db->order_by('p.mp_c');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_una_factura($id){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_i_cliente c','c.cli_id=f.cli_id');
		$this->db->join('erp_emisor m','m.emi_id=f.emi_id');
		$this->db->join('erp_empresas em','em.emp_id=f.emp_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where('fac_id',$id);
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function lista_una_factura_num($id){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_i_cliente c','c.cli_id=f.cli_id');
		$this->db->join('erp_emisor m','m.emi_id=f.emi_id');
		$this->db->join('erp_empresas em','em.emp_id=f.emp_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where('fac_numero',$id);
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function lista_factura_numero($id,$emi){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_i_cliente c','c.cli_id=f.cli_id');
		$this->db->join('erp_emisor m','m.emi_id=f.emi_id');
		$this->db->join('erp_empresas em','em.emp_id=f.emp_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where("(f.fac_estado=4 or f.fac_estado=6)");
		$this->db->where('f.emi_id',$emi);
		$this->db->where('f.fac_numero',$id);
		$this->db->where('f.fac_estado!=3',null);
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_factura_num_empresa($id,$emp){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_i_cliente c','c.cli_id=f.cli_id');
		$this->db->join('erp_emisor m','m.emi_id=f.emi_id');
		$this->db->join('erp_empresas em','em.emp_id=f.emp_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where("(f.fac_estado=4 or f.fac_estado=6)");
		$this->db->where('f.emp_id',$emp);
		$this->db->where('f.fac_numero',$id);
		$this->db->where('f.fac_estado!=3',null);
		$resultado=$this->db->get();
		return $resultado->result();
			
	}


	public function lista_detalle_factura($id){
		$this->db->from('erp_det_factura d');
		$this->db->join('erp_mp p','d.pro_id=p.id');
		$this->db->where('fac_id',$id);
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_pagos_factura($id){
		$this->db->from('erp_pagos_factura p');
		$this->db->join('erp_formas_pago f','cast(p.pag_forma as integer)=f.fpg_id');
		$this->db->where('com_id',$id);
		$this->db->where('pag_estado','1');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function insert($data){
		$this->db->insert("erp_factura",$data);
		return $this->db->insert_id();
	}

	public function insert_detalle($data){
		return $this->db->insert("erp_det_factura",$data);
	}

	public function insert_pagos($data){
		return $this->db->insert("erp_pagos_factura",$data);
	}

	public function lista_un_producto($id){
		$this->db->select("p.*,tmp.*,(select tps_nombre from erp_tipos where tps_id=cast(mp_b as integer)) as tip_nombre, c.cat_descripcion,e.est_descripcion");
		$this->db->from('erp_mp p');
		$this->db->join('erp_tipos tmp','tmp.tps_id=cast(p.mp_a as integer)');
		$this->db->join('erp_categorias c','c.cat_id=cast(tmp.tps_tipo as integer)');
		$this->db->join('erp_estados e','e.est_id=cast(p.mp_i as integer)');
		$this->db->where('id',$id);
		$this->db->order_by('c.cat_descripcion');
		$this->db->order_by('p.mp_c');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function update($id,$data){
		$this->db->where('fac_id',$id);
		return $this->db->update("erp_factura",$data);
			
	}

	public function delete($id){
		$this->db->where('id',$id);
		return $this->db->delete("erp_factura");
			
	}


	public function total_ingreso_egreso_fact($id, $txt) {
       
        $query ="select(SELECT SUM(m.mov_cantidad)as suma FROM erp_i_mov_inv_pt m, erp_transacciones t WHERE m.trs_id=t.trs_id and m.pro_id=$id and t.trs_operacion= 0 $txt and mov_estado=1) as ingreso,
                                   (SELECT SUM(m.mov_cantidad)as suma FROM erp_i_mov_inv_pt m, erp_transacciones t WHERE m.trs_id=t.trs_id and m.pro_id=$id  and t.trs_operacion= 1 $txt and mov_estado=1) as egreso";
        $resultado=$this->db->query($query);
		return $resultado->row();
    }
    
	

	public function lista_costos_mov($id, $txt) {
        $query ="select (select sum(m.mov_val_tot)  from erp_i_mov_inv_pt m, erp_transacciones t where m.trs_id=t.trs_id and m.pro_id=$id and t.trs_operacion='0' $txt and mov_estado=1) as ingreso,
                                    (select sum(m.mov_val_tot)  from erp_i_mov_inv_pt m, erp_transacciones t where m.trs_id=t.trs_id and m.pro_id=$id and t.trs_operacion='1' $txt and mov_estado=1) as egreso,
                                    (select sum(m.mov_cantidad)  from erp_i_mov_inv_pt m, erp_transacciones t where m.trs_id=t.trs_id and m.pro_id=$id and t.trs_operacion='0' $txt and mov_estado=1) as icnt,
                                    (select sum(m.mov_cantidad)  from erp_i_mov_inv_pt m, erp_transacciones t where m.trs_id=t.trs_id and m.pro_id=$id and t.trs_operacion='1' $txt and mov_estado=1) as ecnt";
        $resultado=$this->db->query($query);
		return $resultado->row();
    }

    public  function lista_notcre_cliente($id) {
		$this->db->from('erp_cheques');
		$this->db->where('cli_id',$id);
		$this->db->where('chq_tipo_doc','8');
		$this->db->where('chq_estado_cheque !=','3');
		$resultado=$this->db->get();
		return $resultado->result();
    }

    public  function lista_un_cheque($id) {
		$this->db->from('erp_cheques');
		$this->db->where('chq_id',$id);
		$resultado=$this->db->get();
		return $resultado->row();
    }

    public function insert_cliente($data){
		
		$this->db->insert("erp_i_cliente",$data);
		return $this->db->insert_id();
			
	}

	public function delete_detalle($id){
		$this->db->where('fac_id',$id);
		return $this->db->delete("erp_det_factura");
			
	}

	public function update_pagos($id,$data){
		$this->db->where('com_id',$id);
		return $this->db->update("erp_pagos_factura",$data);
			
	}

	public function insert_movimientos($data){
		
		return $this->db->insert("erp_i_mov_inv_pt",$data);
			
	}

	public function update_movimientos($num,$id,$data){
		$this->db->where('mov_documento',$num);
		$this->db->where('bod_id',$id);
		$this->db->where('trs_id','25');
		return $this->db->update("erp_i_mov_inv_pt",$data);
			
	}

	public function lista_nota_credito_factura($id){
		$this->db->from('erp_nota_credito');
		$this->db->where('fac_id',$id);
		$this->db->where('ncr_estado !=','3');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function lista_guia_factura($id){
		$this->db->from('erp_guia_remision');
		$this->db->where('fac_id',$id);
		$this->db->where('gui_estado !=','3');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function lista_retencion_factura($id){
		$this->db->from('erp_registro_retencion');
		$this->db->where('fac_id',$id);
		$this->db->where('rgr_estado !=','3');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function lista_factura_sin_autorizar(){
		$this->db->from('erp_factura f');
		$this->db->join('erp_vendedor v','f.vnd_id=v.vnd_id');
		$this->db->join('erp_i_cliente c','c.cli_id=f.cli_id');
		$this->db->join('erp_emisor m','m.emi_id=f.emi_id');
		$this->db->join('erp_empresas em','em.emp_id=f.emp_id');
		$this->db->join('erp_estados e','f.fac_estado=e.est_id');
		$this->db->where('fac_estado', '4');
		$this->db->order_by('fac_id','desc');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}
    
}

?>
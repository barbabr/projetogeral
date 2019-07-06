<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StocksModel;

class Stocks extends BaseController{

    // ==================================================
    public function index(){
        echo view('stocks/main');
    }





    // ==================================================
    // FAMILIAS
    // ==================================================
    public function familias(){

        // carregar os dados das famílias para passar para a view
        $model = new StocksModel();
        $data['familias'] = $model->get_all_families();

        // echo '<pre>';
        // print_r($data['familias']);
        // echo '</pre>';
        // die();
        echo view('stocks/familias', $data);
    }

    // ==================================================
    public function familia_adicionar(){

        // adicionar nova família

        // carregar os dados das famílias para passar para a view
        $model = new StocksModel();
        $data['familias'] = $model->get_all_families();
        $error = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // vamos buscar os dados submetidos pelo formulário
            $request = \Config\Services::request();            
            
            // verificar se já existe a família com mesmo nome
            $resultado = $model->check_family($request->getPost('text_designacao'));
            if($resultado){
                $error = 'Já existe uma família com a mesma designação';
            }
            
            // guardar a nova família na base de dados
            if($error == ''){
                $model->family_add();
                $data['success'] = "Família adicionada com sucesso.";
                $data['familias'] = $model->get_all_families();
            } else {
                $data['error'] = $error;
            }
        }

        echo view('stocks/familias_adicionar', $data);
    }

    // ==================================================
    public function familia_editar($id_familia){
        
        // editar família

        // carregar os dados das famílias para passar para a view
        $model = new StocksModel();
        $data['familias'] = $model->get_all_families();
        $data['familia'] = $model->get_family($id_familia);
        $error = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // vamos buscar os dados submetidos pelo formulário
            $request = \Config\Services::request();            
            
            // verificar se já existe a família com mesmo nome
            $resultado = $model->check_other_family($request->getPost('text_designacao'), $id_familia);
            if($resultado){
                $error = 'Já existe outra família com a mesma designação';
            }
            
            // atualizar os dados da família na base de dados
            if($error == ''){
                $model->family_edit($id_familia);
                $data['success'] = "Família atualizada com sucesso.";
                
                // redirecionamento para stocks/familias
                return redirect()->to(site_url('stocks/familias'));

            } else {
                $data['error'] = $error;
            }
        }

        echo view('stocks/familias_editar', $data);

    }

    // ==================================================
    public function familia_eliminar($id_familia){
        echo 'formulário para editar família';
    }











    // ==================================================
    public function movimentos(){
        echo view('stocks/movimentos');
    }










    // ==================================================
    public function produtos(){
        echo view('stocks/produtos');
    }










    // ==================================================
    public function taxas(){
        echo view('stocks/taxas');
    }



}
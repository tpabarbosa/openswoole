<?php

namespace App;

use Swoole\Http\Request;
use Swoole\Http\Response;

class VeiculosController
{
    private $model;
    private $errors;

    public function __construct()
    {
        $this->model = new VeiculosModel();
    }

    public function getAll(Request $request, Response $response)
    {
        $response->header('Content-Type', 'application/json');
        $response->status(200);
        $response->end(json_encode($this->model->getAll()));
        return;
    }

    public function find(Request $request, Response $response)
    {
        $query = $request->get;
        var_dump($query);
        if (!isset($query['q'])) {
            $this->badRequest($response, ['query' => 'Parâmetro de busca q não informado']);
            return;
        }
        $result = $this->model->find($query['q']);
        if ($result) {
            $response->status(200);
            $response->header('Content-Type', 'application/json');
            $response->end(json_encode($result));
            return;
        }
        $this->notFound($response, 'Nenhum veículo encontrado');
    }

    public function update(Request $request, Response $response)
    {
        $data = json_decode($request->getContent());
        if (!$this->isValid($data, true)) {
            $this->badRequest($response, $this->errors);
        }
        if ($data->vendido === true) {
            $data->vendido = 1;
        } else {
            $data->vendido = 0;
        }
        $result  = $this->model->update($data);
        if ($result) {
            $response->status(200);
            $response->header('Content-Type', 'application/json');
            $response->end(json_encode(['message' => 'Veículo atualizado com sucesso!']));
            return;
        }
        $this->badRequest($response, ['database' => 'Erro ao atualizar veículo']);
    }

    public function create(Request $request, Response $response)
    {
        $data = json_decode($request->getContent());

        if (!$this->isValid($data)) {
            $this->badRequest($response, $this->errors);
            return;
        }
        if ($data->vendido === true) {
            $data->vendido = 1;
        } else {
            $data->vendido = 0;
        }
        $result  = $this->model->save($data);
        if ($result) {
            $response->status(201);
            $response->header('Content-Type', 'application/json');
            $response->end(json_encode(['message' => 'Veículo cadastrado com sucesso!']));
            return;
        }
        $this->badRequest($response, ['database' => 'Erro ao cadastrar veículo']);
    }

    private function isValid($data, $checkId = false)
    {
        //incluir outras verificações
        $errors = [];
        if ($checkId && (!isset($data->id) || empty($data->id))) {
            $errors['id'] = 'O campo id é obrigatório';
        }

        if (!isset($data->veiculo) || empty($data->veiculo)) {
            $errors['veiculo'] = 'O campo veículo é obrigatório';
        }
        if (!isset($data->marca) || empty($data->marca)) {
            $errors['marca'] = 'O campo marca é obrigatório';
        }

        if (!isset($data->ano) || empty($data->ano) || is_int($data->ano)) {
            $errors['ano'] = 'O campo ano é obrigatório e deve ser um número inteiro';
        }
        if (!isset($data->descricao) || empty($data->descricao)) {
            $errors['descricao'] = 'O campo descrição é obrigatório';
        }
        if (!isset($data->vendido) || !is_bool($data->vendido)) {
            $errors['vendido'] = 'O campo vendido deve ser verdadeiro ou falso';
        }
        $this->errors=$errors;
        return ($errors) ? false : true;
    }

    private function badRequest($response, $message)
    {
        $response->status(400);
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode(['errors' => $message]));
    }

    private function NotFound(Response $response, $message)
    {
        $response->status(404);
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode(['message' => $message]));
    }
}

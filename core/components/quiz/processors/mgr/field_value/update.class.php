<?php

class QuizFieldValueUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizFieldValue::class;
    public $languageTopics = ['quiz'];


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = $this->properties['id'];

        if ($id === '' || $id === null) {
            return $this->modx->lexicon($this->objectType . '_err_ns');
        }
        
        $id = (int)$id;

        $field_id = $this->properties['field_id'];
        foreach (['label', 'value'] as $name) {
            $value = $this->properties[$name];
            if ($value === '' || $value === null) {
                $this->modx->error->addField($name, $this->modx->lexicon($this->objectType . '_err_field'));
            } elseif ($this->modx->getCount($this->classKey, [
                $name => $value,
                'id:!=' => $id,
                'field_id' => $field_id
            ])) {
                $this->modx->error->addField($name, $this->modx->lexicon($this->objectType . '_err_ae'));
            }
        }

        return parent::beforeSet();
    }
}

return 'QuizFieldValueUpdateProcessor';

<?php

namespace Routing;

use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
  '' => function (): HTMLRenderer {
    return new HTMLRenderer('file_upload', []);
  },
  'api/images/upload' => function (): JSONRenderer {
    return new JSONRenderer([
      // TODO: 画像を保存する
      // TODO: 画像のURLを返す
      'uniqueString' => 'uniqueString',
    ]);
  },
  'api/images' => function (string $uniqueString = ''): JSONRenderer {
    return new JSONRenderer([
      // TODO: 画像を表示する
      'uniqueString' => $uniqueString,
    ]);
  },
  'api/images/delete' => function (string $uniqueString = ''): JSONRenderer {
    return new JSONRenderer([
      // TODO: 画像を削除する
      'uniqueString' => $uniqueString,
    ]);
  },
];
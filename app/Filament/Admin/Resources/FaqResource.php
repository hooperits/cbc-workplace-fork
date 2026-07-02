<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Administración';

    public static function getModelLabel(): string
    {
        return __('Pregunta Frecuente');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Preguntas Frecuentes');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('Contenido'))
                    ->schema([
                        Infolists\Components\TextEntry::make('question')
                            ->label(__('Pregunta'))
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('answer')
                            ->label(__('Respuesta'))
                            ->html()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('youtube_id')
                            ->label(__('ID Video YouTube'))
                            ->visible(fn (Faq $record) => $record->hasVideo()),
                    ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('question')
                            ->label(__('Pregunta'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('answer')
                            ->label(__('Respuesta'))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('youtube_id')
                            ->label(__('ID del Video de YouTube'))
                            ->helperText('Ejemplo: uZUWu3OtuTs (solo el ID, no la URL completa)')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('Orden'))
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Activo'))
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label(__('Pregunta'))
                    ->limit(70)
                    ->searchable(),
                Tables\Columns\IconColumn::make('youtube_id')
                    ->label(__('Video'))
                    ->boolean()
                    ->getStateUsing(fn (Faq $record) => $record->hasVideo()),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('Orden'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Activo'))
                    ->boolean()
                    ->action(function (Faq $record): void {
                        $record->is_active = ! $record->is_active;
                        $record->save();
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(false)
                    ->tooltip(__('common.actions.edit.tooltip')),
                Tables\Actions\ViewAction::make()
                    ->label(false)
                    ->tooltip(__('common.actions.view.tooltip')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'view' => Pages\ViewFaq::route('/{record}'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
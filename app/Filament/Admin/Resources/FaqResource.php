<?php

namespace App\Filament\Admin\Resources;

use App\Enums\FaqModule;
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
        return __('models/faq.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models/faq.plural-label');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('models/faq.sections.content'))
                    ->schema([
                        Infolists\Components\TextEntry::make('module')
                            ->label(__('models/faq.fields.module'))
                            ->badge(),
                        Infolists\Components\TextEntry::make('question')
                            ->label(__('models/faq.fields.question'))
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('answer')
                            ->label(__('models/faq.fields.answer'))
                            ->html()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('youtube_id')
                            ->label(__('models/faq.fields.youtube_id'))
                            ->visible(fn (Faq $record) => $record->hasVideo()),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label(__('models/faq.fields.is_active'))
                            ->boolean(),
                    ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('module')
                            ->label(__('models/faq.fields.module'))
                            ->options(collect(FaqModule::cases())->mapWithKeys(
                                fn (FaqModule $m) => [$m->value => $m->getLabel()]
                            )->all())
                            ->required()
                            ->native(false)
                            ->default(FaqModule::GENERAL->value),
                        Forms\Components\TextInput::make('question')
                            ->label(__('models/faq.fields.question'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('answer')
                            ->label(__('models/faq.fields.answer'))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('youtube_id')
                            ->label(__('models/faq.fields.youtube_id'))
                            ->helperText(__('models/faq.fields.youtube_id_helper'))
                            ->maxLength(50),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('models/faq.fields.sort_order'))
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('models/faq.fields.is_active'))
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
                Tables\Columns\TextColumn::make('module')
                    ->label(__('models/faq.fields.module'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question')
                    ->label(__('models/faq.fields.question'))
                    ->limit(70)
                    ->searchable(),
                Tables\Columns\IconColumn::make('youtube_id')
                    ->label(__('models/faq.fields.video'))
                    ->boolean()
                    ->getStateUsing(fn (Faq $record) => $record->hasVideo()),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('models/faq.fields.sort_order'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('models/faq.fields.is_active'))
                    ->boolean()
                    ->action(function (Faq $record): void {
                        $record->is_active = ! $record->is_active;
                        $record->save();
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('module')
                    ->label(__('models/faq.fields.module'))
                    ->options(collect(FaqModule::cases())->mapWithKeys(
                        fn (FaqModule $m) => [$m->value => $m->getLabel()]
                    )->all()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('models/faq.fields.is_active')),
                Tables\Filters\Filter::make('has_video')
                    ->label(__('models/faq.fields.video'))
                    ->query(fn ($query) => $query->whereNotNull('youtube_id')->where('youtube_id', '!=', '')),
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
        return [];
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
